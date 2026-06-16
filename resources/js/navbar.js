// Mobile Menu Toggle
const navbarToggle = document.getElementById('navbarToggle');
const navbarMenu = document.getElementById('navbarMenu');

if (navbarToggle && navbarMenu) {
  navbarToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    navbarToggle.classList.toggle('active');
    navbarMenu.classList.toggle('show');
  });

  // Close menu when clicking on a link
  const navLinks = navbarMenu.querySelectorAll('.nav-link');
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      navbarToggle.classList.remove('active');
      navbarMenu.classList.remove('show');
    });
  });
}

// Dropdown Menu
const profileBtn = document.getElementById('profileBtn');
const dropdownMenu = document.getElementById('dropdownMenu');

if (profileBtn && dropdownMenu) {
  profileBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    dropdownMenu.classList.toggle('show');
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', function() {
    dropdownMenu.classList.remove('show');
  });

  // Prevent closing when clicking inside dropdown
  dropdownMenu.addEventListener('click', function(e) {
    e.stopPropagation();
  });
}

// Close menu when clicking outside
document.addEventListener('click', function() {
  if (navbarToggle && navbarMenu) {
    navbarToggle.classList.remove('active');
    navbarMenu.classList.remove('show');
  }
});
