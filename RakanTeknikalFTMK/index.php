<?php
session_start();

$error = $_GET["error"] ?? "";
$registered = $_GET["registered"] ?? "";
$logout = $_GET["logout"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Rakan Teknikal FTMK Login</title>

  <link rel="stylesheet" href="style.css?v=3" />
</head>
<body>
  <main class="login-page">
    <section class="left-section">
      <img
        class="logo-img"
        src="images/ftmk.png"
        alt="UTeM and FTMK Logo"
      />

      <img
        class="hero-img"
        src="images/fantastic5.png"
        alt="Fantastic5 Illustration"
      />

      <h2 class="system-title">Rakan Teknikal FTMK</h2>
    </section>

    <section class="right-section">
      <form class="login-box" id="loginForm" action="login.php" method="POST" autocomplete="off">
        <h1>Welcome Back !</h1>

        <div class="input-group">
          <label for="userId">User Id</label>
          <input
            type="text"
            id="userId"
            name="userId"
            required
          />
        </div>

        <div class="input-group password-group">
          <label for="password">Password</label>

          <div class="password-wrapper">
            <input
              type="password"
              id="password"
              name="password"
              required
            />

            <button
              type="button"
              class="toggle-password"
              id="togglePassword"
              aria-label="Show password"
            >
              <svg id="eyeIcon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7Zm0 11.5A4.5 4.5 0 1 1 12 7a4.5 4.5 0 0 1 0 9.5Zm0-2A2.5 2.5 0 1 0 12 9a2.5 2.5 0 0 0 0 5.5Z"/>
              </svg>
            </button>
          </div>
        </div>

        <p class="error-message" id="errorMessage">
          <?php
            if ($error === "empty") {
              echo "Please enter User Id and Password.";
            } elseif ($error === "invalid") {
              echo "Invalid User Id or Password.";
            } elseif ($error === "unauthorized") {
              echo "Please login first.";
            }
          ?>
        </p>

        <?php if ($registered === "1"): ?>
          <p class="success-message">Registration successful. You can login now.</p>
        <?php elseif ($logout === "1"): ?>
          <p class="success-message">Logged out successfully.</p>
        <?php endif; ?>

        <button type="submit" class="login-btn">Login</button>

        <p class="register-text">
          New student?
          <a href="register-student.php">Register here</a>
        </p>
      </form>
    </section>
  </main>

  <script src="script.js?v=2"></script>
</body>
</html>
