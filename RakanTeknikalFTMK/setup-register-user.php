<?php
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $role = $_POST["role"] ?? "";
    $password = trim($_POST["password"] ?? "");

    if ($password === "") {
        $message = "Password is required.";
    } elseif ($role === "student") {
        $matricNo = strtoupper(trim($_POST["matric_no"] ?? ""));
        $fullName = trim($_POST["full_name"] ?? "");
        $preferredName = trim($_POST["preferred_name"] ?? "");
        $programme = trim($_POST["programme"] ?? "");
        $yearSem = trim($_POST["year_sem"] ?? "");
        $statusCategory = trim($_POST["status_category"] ?? "");

        if ($matricNo === "" || $fullName === "" || $programme === "" || $yearSem === "" || $statusCategory === "") {
            $message = "Please fill in all student fields.";
        } else {
            try {
                $conn->begin_transaction();

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("
                    INSERT INTO users (login_id, password_hash, role)
                    VALUES (?, ?, 'student')
                ");
                $stmt->bind_param("ss", $matricNo, $passwordHash);
                $stmt->execute();

                $userId = $conn->insert_id;

                $stmt = $conn->prepare("
                    INSERT INTO students
                    (user_id, matric_no, full_name, preferred_name, programme, year_sem, status_category)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->bind_param(
                    "issssss",
                    $userId,
                    $matricNo,
                    $fullName,
                    $preferredName,
                    $programme,
                    $yearSem,
                    $statusCategory
                );
                $stmt->execute();

                $conn->commit();

                $message = "Student added successfully. Login ID is: " . e($matricNo);
            } catch (mysqli_sql_exception $e) {
                $conn->rollback();
                $message = "Failed to add student. Maybe the matric number already exists.";
            }
        }
    } elseif ($role === "admin") {
        $staffId = trim($_POST["staff_id"] ?? "");
        $fullName = trim($_POST["admin_full_name"] ?? "");

        if ($staffId === "" || $fullName === "") {
            $message = "Please fill in all admin fields.";
        } else {
            try {
                $conn->begin_transaction();

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("
                    INSERT INTO users (login_id, password_hash, role)
                    VALUES (?, ?, 'admin')
                ");
                $stmt->bind_param("ss", $staffId, $passwordHash);
                $stmt->execute();

                $userId = $conn->insert_id;

                $stmt = $conn->prepare("
                    INSERT INTO admins (user_id, staff_id, full_name)
                    VALUES (?, ?, ?)
                ");
                $stmt->bind_param("iss", $userId, $staffId, $fullName);
                $stmt->execute();

                $conn->commit();

                $message = "Admin added successfully. Login ID is: " . e($staffId);
            } catch (mysqli_sql_exception $e) {
                $conn->rollback();
                $message = "Failed to add admin. Maybe the staff ID already exists.";
            }
        }
    } else {
        $message = "Please choose student or admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Setup Register User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background: #fff5ef;
        }

        form {
            background: white;
            padding: 20px;
            max-width: 600px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        button {
            margin-top: 18px;
            padding: 10px 18px;
            background: #f8b400;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .message {
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>Temporary Setup: Add Real User</h1>

<p class="message"><?php echo $message; ?></p>

<form method="POST">
    <label>Role</label>
    <select name="role" required>
        <option value="">Choose role</option>
        <option value="student">Student</option>
        <option value="admin">Admin</option>
    </select>

    <h2>Student Details</h2>

    <label>Matric No</label>
    <input type="text" name="matric_no" placeholder="Example: D032410187">

    <label>Full Name</label>
    <input type="text" name="full_name" placeholder="Student full name">

    <label>Preferred Name</label>
    <input type="text" name="preferred_name" placeholder="Example: Ain">

    <label>Programme</label>
    <input type="text" name="programme" placeholder="Example: DCS">

    <label>Year/Sem</label>
    <input type="text" name="year_sem" placeholder="Example: 2/2">

    <label>Status</label>
    <input type="text" name="status_category" placeholder="Example: B40">

    <h2>Admin Details</h2>

    <label>Staff ID</label>
    <input type="text" name="staff_id" placeholder="Admin staff ID">

    <label>Admin Full Name</label>
    <input type="text" name="admin_full_name" placeholder="Admin full name">

    <h2>Password</h2>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Add User</button>
</form>

<p>
    After adding your real student/admin accounts, delete this file from your project folder.
</p>

</body>
</html>