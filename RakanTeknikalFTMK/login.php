<?php
require_once "db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$userId = trim($_POST["userId"] ?? "");
$password = trim($_POST["password"] ?? "");

if ($userId === "" || $password === "") {
    header("Location: index.php?error=empty");
    exit;
}

$stmt = $conn->prepare("
    SELECT user_id, login_id, password_hash, role
    FROM users
    WHERE login_id = ?
      AND is_active = 1
    LIMIT 1
");
$stmt->bind_param("s", $userId);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user || !password_verify($password, $user["password_hash"])) {
    header("Location: index.php?error=invalid");
    exit;
}

session_regenerate_id(true);

$_SESSION["user_id"] = (int)$user["user_id"];
$_SESSION["login_id"] = $user["login_id"];
$_SESSION["role"] = $user["role"];

if ($user["role"] === "student") {
    $stmt = $conn->prepare("
        SELECT student_id, matric_no, full_name, preferred_name
        FROM students
        WHERE user_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $user["user_id"]);
    $stmt->execute();

    $student = $stmt->get_result()->fetch_assoc();

    if (!$student) {
        session_unset();
        session_destroy();
        header("Location: index.php?error=invalid");
        exit;
    }

    $_SESSION["student_logged_in"] = true;
    $_SESSION["student_db_id"] = (int)$student["student_id"];
    $_SESSION["student_matric"] = $student["matric_no"];
    $_SESSION["student_full_name"] = $student["full_name"];
    $_SESSION["student_name"] = $student["preferred_name"] ?: strtok($student["full_name"], " ");

    header("Location: student-dashboard.php");
    exit;
}

if ($user["role"] === "admin") {
    $stmt = $conn->prepare("
        SELECT admin_id, staff_id, full_name
        FROM admins
        WHERE user_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $user["user_id"]);
    $stmt->execute();

    $admin = $stmt->get_result()->fetch_assoc();

    if (!$admin) {
        session_unset();
        session_destroy();
        header("Location: index.php?error=invalid");
        exit;
    }

    $_SESSION["admin_logged_in"] = true;
    $_SESSION["admin_db_id"] = (int)$admin["admin_id"];
    $_SESSION["admin_staff_id"] = $admin["staff_id"];
    $_SESSION["admin_name"] = $admin["full_name"];

    header("Location: admin-dashboard.php");
    exit;
}

header("Location: index.php?error=invalid");
exit;
?>