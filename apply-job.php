<?php
require_once "auth.php";
require_student();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: jobs-available.php");
    exit;
}

$student = current_student($conn);
$studentDbId = (int)$student["student_id"];
$jobId = (int)($_POST["job_id"] ?? 0);

if ($jobId <= 0) {
    header("Location: jobs-available.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT job_id
    FROM jobs
    WHERE job_id = ?
      AND is_active = 1
    LIMIT 1
");
$stmt->bind_param("i", $jobId);
$stmt->execute();

$job = $stmt->get_result()->fetch_assoc();

if (!$job) {
    header("Location: jobs-available.php");
    exit;
}

try {
    $stmt = $conn->prepare("
        INSERT INTO applications (student_id, job_id, status)
        VALUES (?, ?, 'Pending')
    ");
    $stmt->bind_param("ii", $studentDbId, $jobId);
    $stmt->execute();

    header("Location: application-success.php");
    exit;
} catch (mysqli_sql_exception $e) {
    header("Location: my-application.php");
    exit;
}
?>