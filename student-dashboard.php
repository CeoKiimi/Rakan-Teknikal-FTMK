<?php
require "auth.php";

$activePage = "dashboard";
$studentName = $_SESSION["student_name"] ?? "Ain";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Student Dashboard</title>

  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="student-dashboard.css" />
</head>
<body>

  <?php include "student-header.php"; ?>

  <main class="dashboard-page">
    <section class="welcome-banner">
      <div class="welcome-text">
        <p class="date-text" id="dateText">14 April 2026</p>
        <h1>Welcome Back, <?php echo htmlspecialchars($studentName); ?></h1>
        <p>Rakan Teknikal helps you earn extra income</p>
      </div>

      <img
        src="images/gambar shopping.png"
        alt="Student dashboard illustration"
        class="banner-img"
      />
    </section>

    <section class="dashboard-grid">
      <div class="dashboard-card">
        <div class="card-title">
          <span class="card-icon">📥</span>
          <h2>Latest Jobs</h2>
        </div>

        <div class="job-box">
          <div>
            <h3>Lab Opener/Closer</h3>
            <p>Level 2 Blok B</p>
            <p>Duration : 1 Week</p>
          </div>

          <button type="button" class="small-btn apply-btn">Apply</button>
        </div>

        <div class="job-box">
          <div>
            <h3>Lab Inventory</h3>
            <p>AI2</p>
            <p>Duration : 2 Weeks</p>
          </div>

          <button type="button" class="small-btn apply-btn">Apply</button>
        </div>

        <div class="card-footer">
          <button class="main-btn">View All Jobs</button>
        </div>
      </div>

      <div class="dashboard-card">
        <div class="card-title">
          <span class="card-icon">🗂️</span>
          <h2>My Applications</h2>
        </div>

        <div class="application-box">
          <div>
            <h3>Room Monitor</h3>
            <p>MPD3</p>
          </div>

          <span class="status approved">Approved</span>
        </div>

        <div class="application-box">
          <div>
            <h3>Key Keeper</h3>
            <p>level G, Blok C</p>
          </div>

          <span class="status pending">Pending</span>
        </div>

        <div class="application-box">
          <div>
            <h3>Software Installer</h3>
            <p>Bengkel BITD</p>
          </div>

          <span class="status rejected">Rejected</span>
        </div>

        <div class="card-footer">
          <button class="main-btn">View More</button>
        </div>
      </div>

      <div class="dashboard-card merit-card">
        <div class="card-title">
          <span class="card-icon">💗</span>
          <h2>Merit</h2>
        </div>

        <div class="gauge">
          <div class="gauge-arc"></div>
          <div class="gauge-cover"></div>
          <p>90%</p>
        </div>

        <p class="merit-text">
          You have an excellent score<br />
          of merit. Keep going!
        </p>
      </div>
    </section>
  </main>

  <script src="student-dashboard.js?v=2"></script>
</body>
</html>