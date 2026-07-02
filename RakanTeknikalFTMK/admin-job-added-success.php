<?php
require_once 'auth.php';
require_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Added Successfully - Rakan Teknikal FTMK</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
<?php include 'admin-header.php'; ?>
<main class="page-panel success-box">
    <h1>Job Added Successfully</h1>
    <img src="assets/jobadded.png" alt="Job added illustration">
    <a class="ok-btn" href="admin-managejobs.php">OK</a>
</main>
</body>
</html>
