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

    $_SESSION['jobs'][] = [
        "job" => $job,
        "location" => $location,
        "start_date" => $start_date,
        "end_date" => $end_date,
        "allowance" => $allowance,
        "todo" => $todo
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Job Added Successfully</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

    <h2>Job Added Successfully</h2>

    <img src="jobadded.png" width="600" style="display:block; margin:auto;">

    <div class="btn page6">
        <button type="button" onclick="history.back()">Back</button>
        <button type="button" onclick="window.location.href='jobsavailable.php'">Ok</button>
    </div>

</div>

</body>
</html>