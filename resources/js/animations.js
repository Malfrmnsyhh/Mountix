document.addEventListener('DOMContentLoaded', function() {
  const revealElements = document.querySelectorAll('.reveal');

  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
        // Unobserve after revealing to prevent repeated animations
        revealObserver.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.1 // Reveal when 10% of the element is visible
  });

  revealElements.forEach(el => {
    revealObserver.observe(el);
  });
});
