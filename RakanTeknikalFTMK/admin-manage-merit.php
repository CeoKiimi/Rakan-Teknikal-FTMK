<?php
require_once 'auth.php';
require_admin();

$stmt = $conn->prepare(" 
    SELECT student_id, matric_no, full_name, programme, year_sem, status_category, merit_score
    FROM students
    ORDER BY full_name ASC
");
$stmt->execute();
$students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profiles & Merit - Rakan Teknikal FTMK</title>
    <link rel="stylesheet" href="admin-style.css?v=7">
</head>
<body>
<?php include 'admin-header.php'; ?>
<main class="page-panel">
    <section class="title-row">
        <div>
            <h1>Student Profiles & Merit</h1>
            <p>View student information and update merit score</p>
        </div>
        <img src="assets/admin.png" alt="Student profile illustration">
    </section>

    <section class="merit-list">
        <?php if (count($students) > 0): ?>
            <?php foreach ($students as $student): ?>
                <?php
                    $meritScore = (int)$student['merit_score'];
                    if ($meritScore < 0) $meritScore = 0;
                    if ($meritScore > 100) $meritScore = 100;
                ?>
                <article class="merit-student-card">
                    <div>
                        <h2><?php echo e($student['full_name']); ?></h2>
                        <p><?php echo e($student['matric_no']); ?> | <?php echo e($student['programme']); ?> | <?php echo e($student['year_sem']); ?> | <?php echo e($student['status_category']); ?></p>
                        <p>Current Merit : <strong><?php echo e($meritScore); ?>%</strong></p>
                    </div>

                    <form action="admin-update-merit.php" method="POST" class="merit-form">
                        <input type="hidden" name="student_id" value="<?php echo (int)$student['student_id']; ?>">
                        <input type="hidden" name="return_to" value="admin-manage-merit.php">
                        <input
                            type="number"
                            name="merit_score"
                            value="<?php echo e($meritScore); ?>"
                            min="0"
                            max="100"
                            required
                        >
                        <button type="submit" class="action-btn green">Update</button>
                        <a class="action-btn yellow" href="admin-view-profile.php?student_id=<?php echo (int)$student['student_id']; ?>">View Profile</a>
                    </form>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <article class="merit-student-card">
                <div>
                    <h2>No students found</h2>
                    <p>Add real student accounts first.</p>
                </div>
            </article>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
