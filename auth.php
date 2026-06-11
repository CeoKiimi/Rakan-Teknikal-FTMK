<?php
session_start();

if (!isset($_SESSION["student_logged_in"]) || $_SESSION["student_logged_in"] !== true) {
  header("Location: index.php?error=unauthorized");
  exit;
}
?>