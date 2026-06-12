<?php
require_once 'auth.php';
require_admin();
require_once 'admin-functions.php';

$stmt = $conn->prepare(" 
    SELECT job_id, title, location, job_date, allowance, todo
    FROM jobs
    WHERE is_active = 1
    ORDER BY created_at DESC
");
$stmt->execute();
$jobs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs - Rakan Teknikal FTMK</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
<?php include 'admin-header.php'; ?>
<main class="page-panel">
    <section class="title-row">
        <div>
            <h1>Manage Jobs</h1>
            <p>Delete and Add Jobs</p>
            <a class="add-job" href="admin-addjob.php">Add Jobs</a>
        </div>
        <img src="assets/manage.png" alt="Manage jobs illustration">
    </section>

    <section class="job-grid">
        <?php if (count($jobs) > 0): ?>
            <?php foreach ($jobs as $job): ?>
                <article class="job-card">
                    <h2><?php echo e($job['title']); ?></h2>
                    <h3><?php echo e($job['location']); ?></h3>
                    <p>Date : <?php echo e($job['job_date']); ?></p>
                    <p>Allowance : <?php echo e($job['allowance']); ?></p>
                    <span class="todo">To Do : <?php echo e($job['todo']); ?></span>

                    <form action="admin-deletejob.php" method="POST" onsubmit="return confirm('Delete this job?')">
                        <input type="hidden" name="job_id" value="<?php echo (int)$job['job_id']; ?>">
                        <button class="delete-btn" type="submit">Delete</button>
                    </form>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <article class="job-card">
                <h2>No jobs available yet</h2>
                <h3>Add a job first</h3>
                <p>Date : -</p>
                <p>Allowance : -</p>
                <span class="todo">To Do : New jobs will appear here after admin submits the add job form.</span>
            </article>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
