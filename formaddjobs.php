<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $job = $_POST['job'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $allowance = $_POST['allowance'];
    $todo = $_POST['todo'];

    if (!isset($_SESSION['jobs'])) {
        $_SESSION['jobs'] = [];
    }

    $_SESSION['jobs'][] = [
        "job" => $job,
        "location" => $location,
        "start_date" => $start_date,
        "end_date" => $end_date,
        "allowance" => $allowance,
        "todo" => $todo
    ];

    header("Location: addjobssuccess.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Jobs</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

    <h1>Add Jobs</h1>

    <form method="post" onsubmit="return checkForm()">

        <div class="row">
            <label>Job :</label>
            <input type="text" id="job" name="job" required>
        </div>

        <div class="row">
            <label>Location :</label>
            <input type="text" id="location" name="location" required>
        </div>

        <div class="row">
            <label>Start Date :</label>
            <input type="date" id="start_date" name="start_date" required>
        </div>

        <div class="row">
            <label>End Date :</label>
            <input type="date" id="end_date" name="end_date" required>
        </div>

        <div class="row">
            <label>Allowance :</label>
            <input type="text" id="allowance" name="allowance" required>
        </div>

        <div class="row">
            <label>To Do :</label>
            <input type="text" id="todo" name="todo" required>
        </div>

        <div class="btn page5">
            <button type="submit">Submit</button>
        </div>

    </form>

</div>

<script src="addjobs.js"></script>

</body>
</html>