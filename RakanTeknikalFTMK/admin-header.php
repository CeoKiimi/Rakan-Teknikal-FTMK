<?php
$current_page = basename($_SERVER['PHP_SELF']);

function admin_nav_active(array $pages, string $current_page): string {
    return in_array($current_page, $pages, true) ? 'active' : '';
}
?>

<div class="header">
    <div>🎲 Fantastic5</div>
    <div>|</div>
    <div>📍 FTMK, Universiti Teknikal Malaysia Melaka</div>
    <div>|</div>
    <div>📞 +06 229 2121</div>
    <div>|</div>
    <div>✉ ftmk@utem.edu.my</div>
</div>

<div class="menu">
    <a class="<?php echo admin_nav_active(['admin-dashboard.php'], $current_page); ?>" href="admin-dashboard.php">Dashboard</a>
    <a class="<?php echo admin_nav_active(['admin-manage-merit.php', 'admin-view-profile.php', 'admin-update-merit.php'], $current_page); ?>" href="admin-manage-merit.php">Profile</a>
    <a class="<?php echo admin_nav_active(['admin-managejobs.php', 'admin-addjob.php', 'admin-job-added-success.php', 'admin-deletejob.php'], $current_page); ?>" href="admin-managejobs.php">Jobs Available</a>
    <a class="<?php echo admin_nav_active(['admin-pendingapplications.php', 'admin-update-application.php'], $current_page); ?>" href="admin-pendingapplications.php">Applications</a>
    <a href="logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
</div>
