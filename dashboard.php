<?php

$conn = mysqli_connect("localhost", "root", "", "nama_database");
$sql = "SELECT full_name, job_title, location FROM applications";
$result = mysqli_query($conn, $sql);

?>

<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)): ?>

    <div class="card">
        <h2><?php echo $row['full_name']; ?></h2>
        <p><?php echo $row['job_title']; ?></p>
        <p><?php echo $row['location']; ?></p>
    </div>

<?php endwhile; ?>

</div>