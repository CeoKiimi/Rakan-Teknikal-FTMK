<?php
require "auth.php";

$activePage = "jobs";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Jobs Available</title>

  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="student-dashboard.css" />
</head>
<body>

  <?php include "student-header.php"; ?>

  <main class="dashboard-page">
    <section class="welcome-banner">
      <div class="welcome-text">
        <p class="date-text">Jobs Available</p>
        <h1>Browse and Apply for jobs</h1>
        <p>Choose available part-time jobs within FTMK</p>
      </div>

      <img
        src="images/gambar shopping.png"
        alt="Jobs illustration"
        class="banner-img"
      />
    </section>

    <section class="dashboard-grid">
      <div class="dashboard-card">
        <div class="job-box">
          <div>
            <h3>Lab Inventory</h3>
            <p>AI2</p>
            <p>Date : 20/4 - 3/5</p>
            <p>Allowance : RM5/Hours</p>
          </div>
          <button class="small-btn">Apply</button>
        </div>
      </div>

      <div class="dashboard-card">
        <div class="job-box">
          <div>
            <h3>Key Keeper</h3>
            <p>Level G, Blok C</p>
            <p>Date : 1/6</p>
            <p>Allowance : RM40</p>
          </div>
          <button class="small-btn">Apply</button>
        </div>
      </div>

      <div class="dashboard-card">
        <div class="job-box">
          <div>
            <h3>Software Installer</h3>
            <p>Bengkel BITD</p>
            <p>Date : 20/4 - 3/5</p>
            <p>Allowance : RM100</p>
          </div>
          <button class="small-btn">Apply</button>
        </div>
      </div>
    </section>
  </main>

  <script src="student-dashboard.js"></script>
</body>
</html>