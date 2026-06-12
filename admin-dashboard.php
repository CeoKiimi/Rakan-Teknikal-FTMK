<?php
require_once 'auth.php';
require_admin();
require_once 'admin-functions.php';

$adminName = $_SESSION['admin_name'] ?? 'Admin';

$jobsStmt = $conn->prepare(" 
    SELECT job_id, title, location, job_date
    FROM jobs
    WHERE is_active = 1
    ORDER BY created_at DESC
    LIMIT 2
");
$jobsStmt->execute();
$latestJobs = $jobsStmt->get_result()->fetch_all(MYSQLI_ASSOC);

$appStmt = $conn->prepare(" 
    SELECT a.application_id, s.full_name, j.title
    FROM applications a
    INNER JOIN students s ON a.student_id = s.student_id
    INNER JOIN jobs j ON a.job_id = j.job_id
    WHERE a.status = 'Pending'
    ORDER BY a.applied_at ASC
    LIMIT 3
");
$appStmt->execute();
$pendingApplications = $appStmt->get_result()->fetch_all(MYSQLI_ASSOC);

$meritStmt = $conn->prepare(" 
    SELECT COALESCE(ROUND(AVG(merit_score)), 0) AS average_merit
    FROM students
");
$meritStmt->execute();
$averageMerit = (int)($meritStmt->get_result()->fetch_assoc()['average_merit'] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rakan Teknikal FTMK</title>
    <link rel="stylesheet" href="admin-style.css?v=7">
</head>
<body>
<?php include 'admin-header.php'; ?>
<main class="page-panel">
    <section class="hero">
        <div>
            <div class="date"><?php echo e(date('d F Y')); ?></div>
            <h1>Welcome Back, <?php echo e(admin_short_name($adminName)); ?></h1>
            <p>Rakan Teknikal helps you manage student part-time jobs.</p>
        </div>
        <img src="assets/manage.png" alt="Admin illustration">
    </section>

    <section class="dashboard-grid">
        <article class="dashboard-card">
            <h2>🗂️ Manage Jobs</h2>
            <div class="mini-list">
                <?php if (count($latestJobs) > 0): ?>
                    <?php foreach ($latestJobs as $job): ?>
                        <div class="mini-item">
                            <strong><?php echo e(admin_short_text($job['title'])); ?></strong>
                            <span><?php echo e($job['location']); ?></span>
                            <span>Date : <?php echo e($job['job_date']); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="mini-item">
                        <strong>No jobs available yet</strong>
                        <span>Add a new job first</span>
                    </div>
                <?php endif; ?>
            </div>
            <a class="primary-link" href="admin-managejobs.php">View All Jobs</a>
        </article>

        <article class="dashboard-card">
            <h2>🗃️ Pending Applications</h2>
            <div class="mini-list">
                <?php if (count($pendingApplications) > 0): ?>
                    <?php foreach ($pendingApplications as $app): ?>
                        <div class="mini-item">
                            <strong><?php echo e(admin_short_text($app['full_name'])); ?></strong>
                            <span><?php echo e($app['title']); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="mini-item">
                        <strong>No pending applications</strong>
                        <span>Student applications will appear here</span>
                    </div>
                <?php endif; ?>
            </div>
            <a class="primary-link" href="admin-pendingapplications.php">View More</a>
        </article>

        <article class="dashboard-card">
            <h2>💖 Manage Merit</h2>
            <div class="merit-circle"><span><?php echo e($averageMerit); ?>%</span></div>
            <p class="centered-note">Update each student's merit score from the Profile page.</p>
            <a class="primary-link" href="admin-manage-merit.php">View More</a>
        </article>
    </section>
</main>
</body>
</html>
