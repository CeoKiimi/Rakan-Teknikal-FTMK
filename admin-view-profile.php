<?php
require_once 'auth.php';
require_admin();
require_once 'admin-functions.php';

$studentId = (int)($_GET['student_id'] ?? 0);

if ($studentId <= 0) {
    header('Location: admin-manage-merit.php');
    exit;
}

$stmt = $conn->prepare(" 
    SELECT student_id, matric_no, full_name, programme, year_sem, status_category, merit_score
    FROM students
    WHERE student_id = ?
    LIMIT 1
");
$stmt->bind_param('i', $studentId);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    header('Location: admin-manage-merit.php');
    exit;
}

$meritScore = (int)$student['merit_score'];
if ($meritScore < 0) $meritScore = 0;
if ($meritScore > 100) $meritScore = 100;

$earnStmt = $conn->prepare(" 
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
$earnStmt->bind_param('i', $studentId);
$earnStmt->execute();
$completedJobs = $earnStmt->get_result()->fetch_all(MYSQLI_ASSOC);

$totalEarnings = 0;
foreach ($completedJobs as $job) {
    $totalEarnings += (float)$job['amount'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Profile - Rakan Teknikal FTMK</title>
    <link rel="stylesheet" href="admin-style.css?v=7">
</head>
<body>
<?php include 'admin-header.php'; ?>
<main class="page-panel">
    <section class="profile-card">
        <div class="avatar">👤</div>
        <div>
            <h2><?php echo e($student['full_name']); ?></h2>
            <p>Matric No : <?php echo e($student['matric_no']); ?></p>
            <p>Programme : <?php echo e($student['programme']); ?></p>
            <p>Year/Sem : <?php echo e($student['year_sem']); ?></p>
            <p>Status : <?php echo e($student['status_category']); ?></p>
            <p>Merit : <strong><?php echo e($meritScore); ?>%</strong></p>

            <form action="admin-update-merit.php" method="POST" class="merit-form" style="margin-top: 12px;">
                <input type="hidden" name="student_id" value="<?php echo (int)$student['student_id']; ?>">
                <input type="hidden" name="return_to" value="admin-view-profile.php">
                <input
                    type="number"
                    name="merit_score"
                    value="<?php echo e($meritScore); ?>"
                    min="0"
                    max="100"
                    required
                >
                <button type="submit" class="action-btn green">Update Merit</button>
            </form>
        </div>
    </section>

    <section class="earnings">
        <div>
            <h2>💰 Total Earnings</h2>
            <div class="money-graphic">💵</div>
            <div class="total"><?php echo e(format_rm($totalEarnings)); ?></div>
        </div>
        <div class="earning-list">
            <?php if (count($completedJobs) > 0): ?>
                <?php foreach ($completedJobs as $job): ?>
                    <article class="earning-card">
                        <div>
                            <strong><?php echo e($job['title']); ?></strong>
                            <span><?php echo e($job['location']); ?></span>
                            <span><?php echo e(format_rm($job['amount'])); ?></span>
                        </div>
                        <span class="status completed">Completed</span>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <article class="earning-card">
                    <div>
                        <strong>No completed jobs yet</strong>
                        <span>Completed earnings will appear here</span>
                        <span>RM0</span>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </section>
</main>
</body>
</html>
