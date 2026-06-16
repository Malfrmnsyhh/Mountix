// Video Demo Modal
const videoDemo = document.getElementById('videoDemo');
if (videoDemo) {
  videoDemo.addEventListener('click', () => {
    alert('Video demo akan segera hadir! Kami sedang menyiapkan panduan terbaik untuk petualangan Anda.');
  });
}

// Smooth scroll indicator
const scrollIndicator = document.getElementById('scrollIndicator');
if (scrollIndicator) {
  scrollIndicator.addEventListener('click', () => {
    const nextSection = document.getElementById('gunungPopuler');
    if (nextSection) {
      nextSection.scrollIntoView({ behavior: 'smooth' });
    }
  });
}

// Parallax effect
window.addEventListener('scroll', () => {
  const hero = document.querySelector('.hero');
  if (hero) {
    const scrollTop = window.scrollY;
    const parallaxElement = hero.querySelector('.hero-image');
    if (parallaxElement) {
      parallaxElement.style.transform = `translateY(${scrollTop * 0.4}px)`;
    }
  }
});
