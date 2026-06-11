<?php
session_start();

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

if ($userId === "nurulain" && $password === "nurulain") {
  $_SESSION["student_logged_in"] = true;
  $_SESSION["student_id"] = "nurulain";
  $_SESSION["student_name"] = "Ain";
  $_SESSION["student_full_name"] = "Nurulain Nabilah binti Hashahar Shah";
  $_SESSION["student_matric"] = "D032410187";

  header("Location: student-dashboard.php");
  exit;
}

header("Location: index.php?error=invalid");
exit;
?>