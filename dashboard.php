<?php

$conn = mysqli_connect("localhost", "root", "", "nama_database");

$sql = "SELECT application_id, full_name, job_title, location
        FROM applications";

$result = mysqli_query($conn, $sql);

$applications = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>