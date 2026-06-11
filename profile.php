<?php
session_start();

$activePage = "profile";
$fullName = $_SESSION["student_full_name"] ?? "Nurulain Nabilah binti Hashahar Shah";
$matricNo = $_SESSION["student_matric"] ?? "D032410187";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Profile</title>

  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="profile.css" />
</head>
<body>

  <?php include "header.php"; ?>

  <main class="profile-page">
    <section class="profile-card">
      <div class="profile-avatar">
        <div class="avatar-hair"></div>
        <div class="avatar-face"></div>
        <div class="avatar-body"></div>
      </div>

      <div class="profile-info">
        <h1><?php echo htmlspecialchars($fullName); ?></h1>

        <p>Matric No : <?php echo htmlspecialchars($matricNo); ?></p>
        <p>Programe : DCS</p>
        <p>Year/Sem : 2/2</p>
        <p>Status : B40</p>
      </div>
    </section>

    <section class="earning-wrapper">
      <div class="earning-card">
        <div class="earning-left">
          <div class="earning-title">
            <span class="coin-icon">$</span>
            <h2>Total Earnings</h2>
          </div>

          <div class="money-icon">💵</div>

          <p class="total-money">RM100</p>
        </div>

        <div class="earning-right">
          <div class="earning-job">
            <div>
              <h3>Lab Inventory</h3>
              <p>MPD3</p>
              <p>RM50</p>
            </div>

            <span class="completed">Completed</span>
          </div>

          <div class="earning-job">
            <div>
              <h3>Food Setup</h3>
              <p>Blok A, C, E</p>
              <p>RM50</p>
            </div>

            <span class="completed">Completed</span>
          </div>
        </div>
      </div>
    </section>
  </main>

</body>
</html>