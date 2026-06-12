<?php
require_once "auth.php";
require_student();

$activePage = "dashboard";
$student = current_student($conn);

$studentDbId = (int)$student["student_id"];
$studentName = $student["preferred_name"] ?: strtok($student["full_name"], " ");

$stmt = $conn->prepare("
    SELECT j.job_id, j.title, j.location, j.job_date, j.allowance, j.todo
    FROM jobs j
    WHERE j.is_active = 1
      AND NOT EXISTS (
        SELECT 1
        FROM applications a
        WHERE a.job_id = j.job_id
          AND a.student_id = ?
      )
    ORDER BY j.created_at DESC
    LIMIT 2
");
$stmt->bind_param("i", $studentDbId);
$stmt->execute();
$latestJobs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $conn->prepare("
    SELECT a.status, j.title, j.location
    FROM applications a
    INNER JOIN jobs j ON a.job_id = j.job_id
    WHERE a.student_id = ?
    ORDER BY a.applied_at DESC
    LIMIT 3
");
$stmt->bind_param("i", $studentDbId);
$stmt->execute();
$applications = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$merit = (int)$student["merit_score"];
if ($merit < 0) $merit = 0;
if ($merit > 100) $merit = 100;

$meritDeg = $merit * 1.8;

function status_class($status) {
    return strtolower($status);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Student Dashboard</title>

  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="student-dashboard.css" />
</head>
<body>

  <?php include "header.php"; ?>

  <main class="dashboard-page">
    <section class="welcome-banner">
      <div class="welcome-text">
        <p class="date-text" id="dateText">14 April 2026</p>
        <h1>Welcome Back, <?php echo e($studentName); ?></h1>
        <p>Rakan Teknikal helps you earn extra income</p>
      </div>

      <img
        src="images/gambar shopping.png"
        alt="Student dashboard illustration"
        class="banner-img"
      />
    </section>

    <section class="dashboard-grid">
      <div class="dashboard-card">
        <div class="card-title">
          <span class="card-icon">📥</span>
          <h2>Latest Jobs</h2>
        </div>

        <?php if (count($latestJobs) > 0): ?>
          <?php foreach ($latestJobs as $job): ?>
            <div class="job-box">
              <div>
                <h3><?php echo e($job["title"]); ?></h3>
                <p><?php echo e($job["location"]); ?></p>
                <p>Date : <?php echo e($job["job_date"]); ?></p>
              </div>

              <form action="apply-job.php" method="POST">
                <input type="hidden" name="job_id" value="<?php echo (int)$job["job_id"]; ?>">
                <button type="submit" class="small-btn apply-btn">Apply</button>
              </form>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="job-box">
            <div>
              <h3>No jobs available yet</h3>
              <p>Please check again later</p>
            </div>
          </div>
        <?php endif; ?>

        <div class="card-footer">
          <button class="main-btn" onclick="window.location.href='jobs-available.php'">
            View All Jobs
          </button>
        </div>
      </div>

      <div class="dashboard-card">
        <div class="card-title">
          <span class="card-icon">🗂️</span>
          <h2>My Applications</h2>
        </div>

        <?php if (count($applications) > 0): ?>
          <?php foreach ($applications as $application): ?>
            <div class="application-box">
              <div>
                <h3><?php echo e($application["title"]); ?></h3>
                <p><?php echo e($application["location"]); ?></p>
              </div>

              <span class="status <?php echo e(status_class($application["status"])); ?>">
                <?php echo e($application["status"]); ?>
              </span>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="application-box">
            <div>
              <h3>No applications yet</h3>
              <p>Apply for a job first</p>
            </div>
          </div>
        <?php endif; ?>

        <div class="card-footer">
          <button class="view-more-btn" onclick="window.location.href='my-application.php'">
            View More
          </button>
        </div>
      </div>

      <div class="dashboard-card merit-card">
        <div class="card-title">
          <span class="card-icon">💗</span>
          <h2>Merit</h2>
        </div>

        <div class="gauge">
          <div class="gauge-arc" style="--merit-deg: <?php echo e($meritDeg); ?>deg;"></div>
          <div class="gauge-cover"></div>
          <p><?php echo e($merit); ?>%</p>
        </div>

        <p class="merit-text">
          You have an excellent score<br />
          of merit. Keep going!
        </p>
      </div>
    </section>
  </main>

  <script src="student-dashboard.js?v=3"></script>
</body>
</html>