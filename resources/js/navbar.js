// Mobile Menu Toggle
const navbarToggle = document.getElementById('navbarToggle');
const navbarMenu = document.getElementById('navbarMenu');

if (navbarToggle && navbarMenu) {
  navbarToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    const isOpen = navbarMenu.classList.toggle('show');
    navbarToggle.classList.toggle('active');
    // Fix a11y: perbarui aria-expanded sesuai state
    navbarToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  // Close menu when clicking on a link
  const navLinks = navbarMenu.querySelectorAll('.nav-link');
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      navbarToggle.classList.remove('active');
      navbarMenu.classList.remove('show');
      navbarToggle.setAttribute('aria-expanded', 'false');
    });
  });
}

// Dropdown Menu
const profileBtn = document.getElementById('profileBtn');
const dropdownMenu = document.getElementById('dropdownMenu');

if (profileBtn && dropdownMenu) {
  profileBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    const isOpen = dropdownMenu.classList.toggle('show');
    // Fix a11y: perbarui aria-expanded sesuai state dropdown
    profileBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', function() {
    if (dropdownMenu.classList.contains('show')) {
      dropdownMenu.classList.remove('show');
      profileBtn.setAttribute('aria-expanded', 'false');
    }
  });

  // Prevent closing when clicking inside dropdown
  dropdownMenu.addEventListener('click', function(e) {
    e.stopPropagation();
  });
}

// Close mobile menu when clicking outside
document.addEventListener('click', function() {
  if (navbarToggle && navbarMenu && navbarMenu.classList.contains('show')) {
    navbarToggle.classList.remove('active');
    navbarMenu.classList.remove('show');
    navbarToggle.setAttribute('aria-expanded', 'false');
  }
});

