<?php
require_once 'auth.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin-pendingapplications.php');
    exit;
}

$applicationId = (int)($_POST['application_id'] ?? 0);
$action = $_POST['action'] ?? '';
$adminId = (int)($_SESSION['admin_db_id'] ?? 0);

if ($applicationId <= 0) {
    header('Location: admin-pendingapplications.php');
    exit;
}

if ($action === 'approve') {
    $status = 'Approved';
} elseif ($action === 'reject') {
    $status = 'Rejected';
} else {
    header('Location: admin-pendingapplications.php');
    exit;
}

$stmt = $conn->prepare(" 
    UPDATE applications
    SET status = ?,
        decided_by = ?,
        decided_at = NOW()
    WHERE application_id = ?
      AND status = 'Pending'
");
$stmt->bind_param('sii', $status, $adminId, $applicationId);
$stmt->execute();

header('Location: admin-pendingapplications.php');
exit;
?>
