const headerContainer = document.getElementById("siteHeader");
const activePage = document.body.dataset.activePage || "";

if (headerContainer) {
  headerContainer.innerHTML = `
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
        <a href="student-dashboard.html" data-page="dashboard">Dashboard</a>
        <a href="profile.html" data-page="profile">Profile</a>
        <a href="jobs-available.html" data-page="jobs">Jobs Available</a>
      </nav>
    </header>
  `;

  const navLinks = document.querySelectorAll(".nav-row a");
  navLinks.forEach((link) => {
    if (link.dataset.page === activePage) {
      link.classList.add("active");
    }
  });
}