<?php
require_once "auth.php";
require_student();

$activePage = "jobs";
$student = current_student($conn);
$studentDbId = (int)$student["student_id"];

$stmt = $conn->prepare("
    SELECT
      j.job_id,
      j.title,
      j.location,
      j.job_date,
      j.allowance,
      j.todo,
      EXISTS (
        SELECT 1
        FROM applications a
        WHERE a.job_id = j.job_id
          AND a.student_id = ?
      ) AS already_applied
    FROM jobs j
    WHERE j.is_active = 1
    ORDER BY j.created_at DESC
");
$stmt->bind_param("i", $studentDbId);
$stmt->execute();
$jobs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs Available</title>

    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="jobs-available.css">
</head>
<body>

<?php include "header.php"; ?>

<main class="jobs-page">

    <section class="jobs-container">

        <div class="jobs-top">

            <div class="jobs-header">
                <h1>Jobs Available</h1>
                <p>Browse and Apply for jobs</p>
            </div>

            <div class="jobs-image">
                <img src="images/gambar jobs.png" alt="Jobs Illustration">
            </div>

        </div>

        <div class="jobs-grid">

            <?php if (count($jobs) > 0): ?>
                <?php foreach ($jobs as $job): ?>
                    <div class="job-card">
                        <h2><?php echo e($job["title"]); ?></h2>
                        <p><?php echo e($job["location"]); ?></p>
                        <p>Date : <?php echo e($job["job_date"]); ?></p>
                        <p>Allowance : <?php echo e($job["allowance"]); ?></p>

                        <div class="todo">
                            To Do : <?php echo e($job["todo"]); ?>
                        </div>

                        <?php if ((int)$job["already_applied"] === 1): ?>
                            <button class="apply-btn" type="button" disabled>Applied</button>
                        <?php else: ?>
                            <form action="apply-job.php" method="POST">
                                <input type="hidden" name="job_id" value="<?php echo (int)$job["job_id"]; ?>">
                                <button class="apply-btn" type="submit">Apply</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="job-card">
                    <h2>No jobs available yet</h2>
                    <p>Please check again later</p>

                    <div class="todo">
                        New jobs will appear here once admin adds them.
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </section>

</main>

<script src="jobs-available.js"></script>

</body>
</html>