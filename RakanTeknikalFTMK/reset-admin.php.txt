<?php
require_once "db.php";

$newPassword = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "UPDATE users SET password_hash=? WHERE login_id='ADM001'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $newPassword);
$stmt->execute();

echo "DONE";
?>