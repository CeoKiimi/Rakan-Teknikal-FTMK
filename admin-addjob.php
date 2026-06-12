<?php
require_once 'auth.php';
require_admin();
require_once 'admin-functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['job'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $jobDate = trim($_POST['job_date'] ?? '');
    $allowance = trim($_POST['allowance'] ?? '');
    $todo = trim($_POST['todo'] ?? '');
    $slots = 1;
    $adminId = (int)($_SESSION['admin_db_id'] ?? 0);
    $allowanceAmount = admin_allowance_amount($allowance);

    if ($title === '' || $location === '' || $jobDate === '' || $allowance === '' || $todo === '') {
        $error = 'Please fill all fields.';
    } else {
        $stmt = $conn->prepare(" 
            INSERT INTO jobs
            (title, location, job_date, allowance, allowance_amount, todo, slots, is_active, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?)
        ");
        $stmt->bind_param(
            'ssssdssi',
            $title,
            $location,
            $jobDate,
            $allowance,
            $allowanceAmount,
            $todo,
            $slots,
            $adminId
        );
        $stmt->execute();

        header('Location: admin-job-added-success.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Jobs - Rakan Teknikal FTMK</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
<?php include 'admin-header.php'; ?>
<main class="page-panel">
    <section class="form-wrap">
        <h1>Add Jobs</h1>
        <?php if ($error !== ''): ?>
            <p class="centered-note" style="color:#ff3535; margin-bottom:20px;"><?php echo e($error); ?></p>
        <?php endif; ?>
        <form method="post" id="addJobForm">
            <div class="form-row">
                <label for="job">Job</label>
                <input type="text" id="job" name="job" required>
            </div>
            <div class="form-row">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-row">
                <label for="job_date">Date</label>
                <input type="text" id="job_date" name="job_date" placeholder="20/4 - 3/5" required>
            </div>
            <div class="form-row">
                <label for="allowance">Allowance</label>
                <input type="text" id="allowance" name="allowance" placeholder="RM50 or RM5/Hours" required>
            </div>
            <div class="form-row">
                <label for="todo">To Do</label>
                <input type="text" id="todo" name="todo" required>
            </div>
            <div class="submit-row">
                <button class="submit-btn" type="submit">Submit</button>
            </div>
        </form>
    </section>
</main>
<script src="admin-script.js"></script>
</body>
</html>
