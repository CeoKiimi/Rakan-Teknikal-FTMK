<?php
require_once 'auth.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin-manage-merit.php');
    exit;
}

$studentId = (int)($_POST['student_id'] ?? 0);
$meritScore = (int)($_POST['merit_score'] ?? 0);
$returnTo = $_POST['return_to'] ?? 'admin-manage-merit.php';

if ($meritScore < 0) {
    $meritScore = 0;
}

if ($meritScore > 100) {
    $meritScore = 100;
}

if ($studentId > 0) {
    $stmt = $conn->prepare(" 
        UPDATE students
        SET merit_score = ?
        WHERE student_id = ?
    ");
    $stmt->bind_param('ii', $meritScore, $studentId);
    $stmt->execute();
}

if ($returnTo === 'admin-view-profile.php') {
    header('Location: admin-view-profile.php?student_id=' . $studentId);
    exit;
}

header('Location: admin-manage-merit.php');
exit;
?>
