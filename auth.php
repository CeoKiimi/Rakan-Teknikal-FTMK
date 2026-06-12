<?php
require_once "db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_login() {
    if (empty($_SESSION["user_id"]) || empty($_SESSION["role"])) {
        header("Location: index.php?error=unauthorized");
        exit;
    }
}

function require_student() {
    require_login();

    if ($_SESSION["role"] !== "student") {
        header("Location: index.php?error=unauthorized");
        exit;
    }
}

function require_admin() {
    require_login();

    if ($_SESSION["role"] !== "admin") {
        header("Location: index.php?error=unauthorized");
        exit;
    }
}

function current_student(mysqli $conn) {
    $studentDbId = $_SESSION["student_db_id"] ?? 0;

    $stmt = $conn->prepare("
        SELECT s.*, u.login_id
        FROM students s
        INNER JOIN users u ON s.user_id = u.user_id
        WHERE s.student_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $studentDbId);
    $stmt->execute();

    $student = $stmt->get_result()->fetch_assoc();

    if (!$student) {
        session_unset();
        session_destroy();
        header("Location: index.php?error=unauthorized");
        exit;
    }

    return $student;
}
?>