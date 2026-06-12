<?php
require_once "auth.php";
require_student();

$activePage = "profile";
$student = current_student($conn);

$studentDbId = (int)$student["student_id"];
$fullName = $student["full_name"];
$matricNo = $student["matric_no"];
$programme = $student["programme"];
$yearSem = $student["year_sem"];
$statusCategory = $student["status_category"];

$stmt = $conn->prepare("
    SELECT
      j.title,
      j.location,
      COALESCE(a.paid_amount, j.allowance_amount, 0) AS amount
    FROM applications a
    INNER JOIN jobs j ON a.job_id = j.job_id
    WHERE a.student_id = ?
      AND a.status = 'Completed'
    ORDER BY a.decided_at DESC, a.applied_at DESC
");
$stmt->bind_param("i", $studentDbId);
$stmt->execute();

$completedJobs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$totalEarnings = 0;

foreach ($completedJobs as $job) {
    $totalEarnings += (float)$job["amount"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Profile</title>

  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="profile.css" />
</head>
<body>

  <?php include "header.php"; ?>

  <main class="profile-page">
    <section class="profile-card">
      <div class="profile-avatar">
        <div class="avatar-hair"></div>
        <div class="avatar-face"></div>
        <div class="avatar-body"></div>
      </div>

      <div class="profile-info">
        <h1><?php echo e($fullName); ?></h1>

        <p>Matric No : <?php echo e($matricNo); ?></p>
        <p>Programe : <?php echo e($programme); ?></p>
        <p>Year/Sem : <?php echo e($yearSem); ?></p>
        <p>Status : <?php echo e($statusCategory); ?></p>
      </div>
    </section>

    <section class="earning-wrapper">
      <div class="earning-card">
        <div class="earning-left">
          <div class="earning-title">
            <span class="coin-icon">$</span>
            <h2>Total Earnings</h2>
          </div>

          <div class="money-icon">💵</div>

          <p class="total-money"><?php echo e(format_rm($totalEarnings)); ?></p>
        </div>

        <div class="earning-right">
          <?php if (count($completedJobs) > 0): ?>
            <?php foreach ($completedJobs as $job): ?>
              <div class="earning-job">
                <div>
                  <h3><?php echo e($job["title"]); ?></h3>
                  <p><?php echo e($job["location"]); ?></p>
                  <p><?php echo e(format_rm($job["amount"])); ?></p>
                </div>

                <span class="completed">Completed</span>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="earning-job">
              <div>
                <h3>No completed jobs yet</h3>
                <p>Your completed jobs will appear here</p>
                <p>RM0</p>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

</body>
</html>