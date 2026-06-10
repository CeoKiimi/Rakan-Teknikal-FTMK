<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $job = $_POST['job'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $allowance = $_POST['allowance'];
    $todo = $_POST['todo'];

    echo "<h2>Job Added Successfully</h2>";

    echo "Job : $job <br>";
    echo "Location : $location <br>";
    echo "Start Date : $start_date <br>";
    echo "End Date : $end_date <br>";
    echo "Allowance : $allowance <br>";
    echo "To Do : $todo <br>";
}

?>