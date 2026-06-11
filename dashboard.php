<?php
$applications = [
    ["full_name"=>"Daus", "job_title"=>"Dev", "location"=>"Melaka"],
    ["full_name"=>"Ain", "job_title"=>"UIUX", "location"=>"KL"],
    ["full_name"=>"Kimi", "job_title"=>"Backend", "location"=>"Johor"]
];

echo "<pre>";
print_r($applications);
echo "</pre>";
?>

<div class="grid">

<?php foreach($applications as $row): ?>

    <div class="card">
        <h2><?php echo $row['full_name']; ?></h2>
    </div>

<?php endforeach; ?>

</div>