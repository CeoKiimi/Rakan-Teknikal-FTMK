<?php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "rakan_teknikal_ftmk";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Database connection failed. Please check db.php database settings.");
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

function format_rm($amount) {
    if ($amount === null || $amount === "") {
        return "RM0";
    }

    $amount = (float)$amount;

    if (floor($amount) == $amount) {
        return "RM" . number_format($amount, 0);
    }

    return "RM" . number_format($amount, 2);
}
?>