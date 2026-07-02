<?php
require_once "auth.php";
require_student();

$activePage = "dashboard";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Application Successful</title>

  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="application-success.css?v=2" />
</head>
<body>

  <?php include "header.php"; ?>

  <main class="application-page">
    <section class="success-card">
      <h1>Application Successful</h1>

      <img
        src="images/application-success.png"
        alt="Application successful illustration"
        class="success-img"
      />

      <p>We will inform you shortly once your application is successful</p>

      <button
        type="button"
        class="ok-btn"
        onclick="window.location.href='student-dashboard.php'"
      >
        OK
      </button>
    </section>
  </main>

</body>
</html>