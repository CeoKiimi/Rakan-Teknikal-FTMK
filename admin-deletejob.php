<?php
require_once 'auth.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin-managejobs.php');
    exit;
}

$jobId = (int)($_POST['job_id'] ?? 0);

if ($jobId > 0) {
    $stmt = $conn->prepare(" 
        UPDATE jobs
        SET is_active = 0
        WHERE job_id = ?
    ");
    $stmt->bind_param('i', $jobId);
    $stmt->execute();
}

header('Location: admin-managejobs.php');
exit;
?>
