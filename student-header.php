<?php
$activePage = $activePage ?? "";
?>

<header class="top-header">
  <div class="top-row">
    <div class="brand-name">Fantastic5</div>

    <div class="header-divider"></div>

    <div class="header-info">
      <span class="header-icon">📍</span>
      <span>FTMK, Universiti Teknikal Malaysia Melaka</span>
    </div>

    <div class="header-divider"></div>

    <div class="header-info">
      <span class="header-icon">📞</span>
      <span>+06 229 2121</span>
    </div>

    <div class="header-divider"></div>

    <div class="header-info">
      <span class="header-icon">✉️</span>
      <span>ftmk@utem.edu.my</span>
    </div>
  </div>  

  <nav class="nav-row">
    <a href="student-dashboard.php" class="<?php echo $activePage === 'dashboard' ? 'active' : ''; ?>">Dashboard</a>
    <a href="profile.php" class="<?php echo $activePage === 'profile' ? 'active' : ''; ?>">Profile</a>
    <a href="jobs-available.php" class="<?php echo $activePage === 'jobs' ? 'active' : ''; ?>">Jobs Available</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>