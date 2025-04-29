// Carousel auto-play
const carousel = document.querySelector('#featuresCarousel');
if (carousel) {
  const bsCarousel = new bootstrap.Carousel(carousel, { interval: 4000, ride: 'carousel' });
}

// Registration form submission
const form = document.getElementById('registrationForm');
const formMessage = document.getElementById('formMessage');
if (form) {
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    formMessage.textContent = 'Thank you for registering! We will contact you soon.';
    formMessage.className = 'alert alert-success';
    form.reset();
    // Close modal after short delay
    setTimeout(() => {
      const modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
      if (modal) modal.hide();
      formMessage.textContent = '';
      formMessage.className = '';
    }, 1500);
  });
}

// Scroll-triggered animation for features and testimonials
function revealOnScroll(selector) {
  const elements = document.querySelectorAll(selector);
  function reveal() {
    elements.forEach(el => {
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight - 40) {
        el.classList.add('visible');
      }
    });
  }
  window.addEventListener('scroll', reveal);
  window.addEventListener('DOMContentLoaded', reveal);
}
revealOnScroll('.feature-box');
revealOnScroll('.testimonial');

// Smooth scroll with offset for fixed navbar
function scrollWithOffset(event, selector) {
  const target = document.querySelector(selector);
  if (target) {
    event.preventDefault();
    const yOffset = 140; // Adjust to match your navbar height
    const y = target.getBoundingClientRect().top + window.pageYOffset - yOffset;
    window.scrollTo({ top: y, behavior: 'smooth' });
  }
}

document.addEventListener('DOMContentLoaded', function() {
  // Features link
  document.querySelectorAll('a[href="#featuresCarousel"]').forEach(link => {
    link.addEventListener('click', function(e) {
      scrollWithOffset(e, '#featuresCarousel');
    });
  });
  // About link
  document.querySelectorAll('a[href="#about"]').forEach(link => {
    link.addEventListener('click', function(e) {
      scrollWithOffset(e, '#about');
    });
  });
  const nextBtn = document.getElementById('nextToBusiness');
  if (nextBtn) {
    nextBtn.addEventListener('click', function() {
      const businessTab = document.getElementById('business-tab');
      if (businessTab) {
        new bootstrap.Tab(businessTab).show();
      }
    });
  }
});
