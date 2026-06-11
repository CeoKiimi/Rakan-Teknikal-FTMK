<?php
session_start();

$activePage = "jobs";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs Available</title>

    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="jobs-available.css">
</head>
<body>

<?php include "header.php"; ?>

<main class="jobs-page">

    <section class="jobs-container">

        <div class="jobs-top">

            <div class="jobs-header">
                <h1>Jobs Available</h1>
                <p>Browse and Apply for jobs</p>
            </div>

            <div class="jobs-image">
                <img src="images/gambar jobs.png" alt="Jobs Illustration">
            </div>

        </div>

        <div class="jobs-grid">

            <div class="job-card">
                <h2>Lab Inventory</h2>
                <p>AI2</p>
                <p>Date : 20/4 - 3/5</p>
                <p>Allowance : RM5/Hours</p>

                <div class="todo">
                    To Do : Ensure lab equipment is properly arranged
                </div>

                <button class="apply-btn">Apply</button>
            </div>

            <div class="job-card">
                <h2>Key Keeper</h2>
                <p>Level G, Blok C</p>
                <p>Date : 1/6</p>
                <p>Allowance : RM40</p>

                <div class="todo">
                    To Do : Open lab, collect and return keys in good condition
                </div>

                <button class="apply-btn">Apply</button>
            </div>

            <div class="job-card">
                <h2>Software Installer</h2>
                <p>Bengkel BITD</p>
                <p>Date : 20/4 - 3/5</p>
                <p>Allowance : RM100</p>

                <div class="todo">
                    To Do : Install and update required software
                </div>

                <button class="apply-btn">Apply</button>
            </div>

            <div class="job-card">
                <h2>Room Monitor</h2>
                <p>Student Room</p>
                <p>Date : 25/5 - 30/5</p>
                <p>Allowance : RM4/Hours</p>

                <div class="todo">
                    To Do : Monitor environment, report any issues
                </div>

                <button class="apply-btn">Apply</button>
            </div>

            <div class="job-card">
                <h2>Equipment Checker</h2>
                <p>MRI</p>
                <p>Date : 23/4</p>
                <p>Allowance : RM60</p>

                <div class="todo">
                    To Do : Check equipment, report damage
                </div>

                <button class="apply-btn">Apply</button>
            </div>

            <div class="job-card">
                <h2>Lab Opener/Closer</h2>
                <p>Level 2, Blok A</p>
                <p>Date : 6/7 - 11/7</p>
                <p>Allowance : RM7/Hours</p>

                <div class="todo">
                    To Do : Open lab before session, close lab after session
                </div>

                <button class="apply-btn">Apply</button>
            </div>

        </div>

    </section>

</main>

<script src="jobs-available.js"></script>

</body>
</html>