<?php
require_once "db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = [];
$values = [
    "matric_no" => "",
    "full_name" => "",
    "preferred_name" => "",
    "programme" => "",
    "year_sem" => "",
    "status_category" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $values["matric_no"] = strtoupper(trim($_POST["matric_no"] ?? ""));
    $values["full_name"] = trim($_POST["full_name"] ?? "");
    $values["preferred_name"] = trim($_POST["preferred_name"] ?? "");
    $values["programme"] = trim($_POST["programme"] ?? "");
    $values["year_sem"] = trim($_POST["year_sem"] ?? "");
    $values["status_category"] = trim($_POST["status_category"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $confirmPassword = trim($_POST["confirm_password"] ?? "");

    if ($values["matric_no"] === "") {
        $errors[] = "Matric No is required.";
    }

    if ($values["full_name"] === "") {
        $errors[] = "Full name is required.";
    }

    if ($values["preferred_name"] === "") {
        $errors[] = "Preferred name is required.";
    }

    if ($values["programme"] === "") {
        $errors[] = "Programme is required.";
    }

    if ($values["year_sem"] === "") {
        $errors[] = "Year/Sem is required.";
    }

    if ($values["status_category"] === "") {
        $errors[] = "Status is required.";
    }

    if ($password === "") {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Password and confirm password do not match.";
    }

    if (empty($errors)) {
        try {
            $conn->begin_transaction();

            $stmt = $conn->prepare("SELECT user_id FROM users WHERE login_id = ? LIMIT 1");
            $stmt->bind_param("s", $values["matric_no"]);
            $stmt->execute();
            $existingUser = $stmt->get_result()->fetch_assoc();

            if ($existingUser) {
                throw new Exception("This Matric No is already registered.");
            }

            $stmt = $conn->prepare("SELECT student_id FROM students WHERE matric_no = ? LIMIT 1");
            $stmt->bind_param("s", $values["matric_no"]);
            $stmt->execute();
            $existingStudent = $stmt->get_result()->fetch_assoc();

            if ($existingStudent) {
                throw new Exception("This Matric No is already registered.");
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                INSERT INTO users (login_id, password_hash, role, is_active)
                VALUES (?, ?, 'student', 1)
            ");
            $stmt->bind_param("ss", $values["matric_no"], $passwordHash);
            $stmt->execute();

            $userId = (int)$conn->insert_id;
            $meritScore = 0;

            $stmt = $conn->prepare("
                INSERT INTO students
                (user_id, matric_no, full_name, preferred_name, programme, year_sem, status_category, merit_score)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param(
                "issssssi",
                $userId,
                $values["matric_no"],
                $values["full_name"],
                $values["preferred_name"],
                $values["programme"],
                $values["year_sem"],
                $values["status_category"],
                $meritScore
            );
            $stmt->execute();

            $conn->commit();

            header("Location: index.php?registered=1");
            exit;
        } catch (Throwable $e) {
            if ($conn->errno === 0) {
                // No mysqli error, but keep rollback safe for validation exceptions.
            }

            try {
                $conn->rollback();
            } catch (Throwable $rollbackError) {
                // Ignore rollback failure if transaction was not active.
            }

            $errors[] = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Student Register</title>

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
      <form class="login-box register-box" id="registerForm" action="register-student.php" method="POST" autocomplete="off">
        <h1>Register</h1>

        <?php if (!empty($errors)): ?>
          <div class="register-errors">
            <?php foreach ($errors as $error): ?>
              <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="input-group">
          <label for="matric_no">Matric No</label>
          <input
            type="text"
            id="matric_no"
            name="matric_no"
            value="<?php echo e($values["matric_no"]); ?>"
            required
          />
        </div>

        <div class="input-group">
          <label for="full_name">Full Name</label>
          <input
            type="text"
            id="full_name"
            name="full_name"
            value="<?php echo e($values["full_name"]); ?>"
            required
          />
        </div>

        <div class="input-group">
          <label for="preferred_name">Preferred Name</label>
          <input
            type="text"
            id="preferred_name"
            name="preferred_name"
            value="<?php echo e($values["preferred_name"]); ?>"
            required
          />
        </div>

        <div class="register-row">
          <div class="input-group">
            <label for="programme">Programme</label>
            <input
              type="text"
              id="programme"
              name="programme"
              value="<?php echo e($values["programme"]); ?>"
              placeholder="DCS"
              required
            />
          </div>

          <div class="input-group">
            <label for="year_sem">Year/Sem</label>
            <input
              type="text"
              id="year_sem"
              name="year_sem"
              value="<?php echo e($values["year_sem"]); ?>"
              placeholder="2/2"
              required
            />
          </div>
        </div>

        <div class="input-group">
          <label for="status_category">Status</label>
          <input
            type="text"
            id="status_category"
            name="status_category"
            value="<?php echo e($values["status_category"]); ?>"
            placeholder="B40"
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

        <div class="input-group">
          <label for="confirm_password">Confirm Password</label>
          <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            required
          />
        </div>

        <button type="submit" class="login-btn">Register</button>

        <p class="register-text">
          Already registered?
          <a href="index.php">Login here</a>
        </p>
      </form>
    </section>
  </main>

  <script src="script.js?v=2"></script>
</body>
</html>
