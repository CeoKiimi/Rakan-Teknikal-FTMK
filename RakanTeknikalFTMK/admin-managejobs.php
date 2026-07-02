<?php
require_once 'auth.php';
require_admin();
require_once 'admin-functions.php';

$q = trim($_GET['q'] ?? '');
$stateFilter = trim($_GET['state'] ?? '');
$sql = "SELECT j.job_id, j.title, j.location, j.job_date, j.allowance, j.todo,
        COUNT(a.application_id) AS application_count,
        SUM(CASE WHEN a.status='Completed' THEN 1 ELSE 0 END) AS completed_count
        FROM jobs j LEFT JOIN applications a ON a.job_id=j.job_id
        WHERE j.is_active=1";
$params=[]; $types='';
if ($q !== '') { $sql .= " AND (j.title LIKE ? OR j.location LIKE ? OR j.todo LIKE ?)"; $like="%$q%"; $params=[$like,$like,$like]; $types='sss'; }
$sql .= " GROUP BY j.job_id ORDER BY j.job_date ASC, j.created_at DESC";
$stmt=$conn->prepare($sql); if($types) $stmt->bind_param($types,...$params); $stmt->execute();
$jobs=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
if($stateFilter!=='') $jobs=array_values(array_filter($jobs, fn($j)=>admin_job_state($j)===$stateFilter));
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Manage Jobs</title><link rel="stylesheet" href="admin-style.css?v=10"></head><body>
<?php include 'admin-header.php'; ?>
<main class="page-panel"><section class="title-row"><div><h1>Manage Jobs</h1><p>Search, filter, update and delete jobs</p><a class="add-job" href="admin-addjob.php">Add Jobs</a></div><img src="assets/manage.png" alt="Manage jobs illustration"></section>
<form class="filter-bar" method="get"><input type="search" name="q" value="<?php echo e($q); ?>" placeholder="Search job/location/todo"><select name="state"><option value="">All Status</option><?php foreach(['Upcoming','Applied','Ended'] as $s): ?><option <?php echo $stateFilter===$s?'selected':''; ?>><?php echo $s; ?></option><?php endforeach; ?></select><button class="action-btn yellow">Search</button></form>
<section class="job-grid"><?php if($jobs): foreach($jobs as $job): $state=admin_job_state($job); $locked=(int)$job['application_count']>0; ?>
<article class="job-card"><h2><?php echo e($job['title']); ?></h2><h3><?php echo e($job['location']); ?></h3><p>Date : <?php echo e($job['job_date']); ?></p><p>Allowance : <?php echo e($job['allowance']); ?></p><p>Applications : <?php echo (int)$job['application_count']; ?></p><span class="status <?php echo strtolower($state); ?>"><?php echo e($state); ?></span><span class="todo">To Do : <?php echo e($job['todo']); ?></span>
<div class="button-row"><a class="action-btn yellow" href="admin-editjob.php?job_id=<?php echo (int)$job['job_id']; ?>"><?php echo $locked?'View':'Edit'; ?></a><form action="admin-deletejob.php" method="POST" onsubmit="return confirm('Delete this job?')"><input type="hidden" name="job_id" value="<?php echo (int)$job['job_id']; ?>"><button class="delete-btn" type="submit">Delete</button></form></div>
<?php if($locked): ?><small class="centered-note">Locked: job cannot be updated because student already applied.</small><?php endif; ?></article>
<?php endforeach; else: ?><article class="job-card"><h2>No jobs found</h2><p>Try different search.</p></article><?php endif; ?></section></main></body></html>
