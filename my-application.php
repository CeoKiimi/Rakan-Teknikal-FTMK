<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Applications</title>

    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="my-application.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<?php include "header.php"; ?>

<div class="applications-page">
    <div class="applications-box">
        <h1>🗂️ My Applications</h1>

        <div class="applications-list">
            <div class="application-card">
                <div>
                    <h3>Lab Inventory</h3>
                    <p>MPD3</p>
                </div>
                <span class="status completed">Completed</span>
            </div>

            <div class="application-card">
                <div>
                    <h3>Key Keeper</h3>
                    <p>level G, Blok C</p>
                </div>
                <span class="status pending">Pending</span>
            </div>

            <div class="application-card">
                <div>
                    <h3>Food Setup</h3>
                    <p>Blok A, C, E</p>
                </div>
                <span class="status completed">Completed</span>
            </div>

            <div class="application-card">
                <div>
                    <h3>Software Installer</h3>
                    <p>MM4</p>
                </div>
                <span class="status rejected">Rejected</span>
            </div>

            <div class="application-card">
                <div>
                    <h3>Software Installer</h3>
                    <p>Bengkel BITD</p>
                </div>
                <span class="status rejected">Rejected</span>
            </div>

            <div class="application-card">
                <div>
                    <h3>Lab Monitor</h3>
                    <p>MPD3</p>
                </div>
                <span class="status approved">Approved</span>
            </div>
        </div>
    </div>
</div>

</body>
</html>