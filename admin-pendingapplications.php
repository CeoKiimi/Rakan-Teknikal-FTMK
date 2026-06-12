<?php
require_once 'auth.php';
require_admin();
require_once 'admin-functions.php';

$stmt = $conn->prepare(" 
    SELECT
        a.application_id,
        a.student_id,
        s.full_name,
        j.title,
        j.location
    FROM applications a
    INNER JOIN students s ON a.student_id = s.student_id
    INNER JOIN jobs j ON a.job_id = j.job_id
    WHERE a.status = 'Pending'
    ORDER BY a.applied_at ASC
");
$stmt->execute();
$applications = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Applications - Rakan Teknikal FTMK</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
<?php include 'admin-header.php'; ?>
<main class="page-panel">
    <section class="title-row">
        <div>
            <h1>Pending Application</h1>
            <p>Manage Applications by approving and rejecting</p>
        </div>
        <img src="assets/admin.png" alt="Pending application illustration">
    </section>

    <section class="application-grid">
        <?php if (count($applications) > 0): ?>
            <?php foreach ($applications as $app): ?>
                <article class="application-card">
                    <h2><?php echo e($app['full_name']); ?></h2>
                    <p><?php echo e($app['title']); ?>, <?php echo e($app['location']); ?></p>
                    <div class="button-row">
                        <form action="admin-update-application.php" method="POST" onsubmit="return confirm('Approve this application?')">
                            <input type="hidden" name="application_id" value="<?php echo (int)$app['application_id']; ?>">
                            <button class="action-btn green" type="submit" name="action" value="approve">Approve</button>
                        </form>
                        <form action="admin-update-application.php" method="POST" onsubmit="return confirm('Reject this application?')">
                            <input type="hidden" name="application_id" value="<?php echo (int)$app['application_id']; ?>">
                            <button class="action-btn red" type="submit" name="action" value="reject">Reject</button>
                        </form>
                        <a class="action-btn yellow" href="admin-view-profile.php?student_id=<?php echo (int)$app['student_id']; ?>">View Profile</a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <article class="application-card">
                <h2>No pending applications</h2>
                <p>Student applications will appear here after they apply for a job.</p>
            </article>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
