<?php
require_once "auth.php";
require_student();

$student = current_student($conn);
$studentDbId = (int)$student["student_id"];

$stmt = $conn->prepare("
    SELECT a.status, j.title, j.location
    FROM applications a
    INNER JOIN jobs j ON a.job_id = j.job_id
    WHERE a.student_id = ?
    ORDER BY a.applied_at DESC
");
$stmt->bind_param("i", $studentDbId);
$stmt->execute();

$applications = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

function status_class($status) {
    return strtolower($status);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Applications</title>

    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="my-application.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<?php include "header.php"; ?>

<div class="applications-page">
    <div class="applications-box">
        <h1>🗂️ My Applications</h1>

        <div class="applications-list">
            <?php if (count($applications) > 0): ?>
                <?php foreach ($applications as $application): ?>
                    <div class="application-card">
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
                <div class="application-card">
                    <div>
                        <h3>No applications yet</h3>
                        <p>Apply for a job first</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>