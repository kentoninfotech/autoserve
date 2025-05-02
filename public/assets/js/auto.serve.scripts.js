// Carousel auto-play
const carousel = document.querySelector('#featuresCarousel');
if (carousel) {
  const bsCarousel = new bootstrap.Carousel(carousel, { interval: 4000, ride: 'carousel' });
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
  
});


// Handle form submission via AJAX to prevent modal from closing
const form = document.getElementById('registrationForm');
if (form) {
  form.addEventListener('submit', async function (e) {
    e.preventDefault(); // Prevent default form submission

    // Clear any previous messages
    const formMessage = document.getElementById('formMessage');
    if (formMessage) {
      formMessage.textContent = '';
      formMessage.className = '';
    }

    // Collect form data
    const formData = new FormData(form);

    try {
      // Send form data to the server
      const response = await fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        },
      });

      if (response.ok) {
        // Handle successful registration by removing the form and displaying the backend response
        const responseData = await response.json();
        const modalBody = form.closest('.modal-body');
        const modalTitle = document.getElementById('registerModalLabel');
        modalTitle.textContent = 'Registration Complete'; // Update modal title
        modalBody.innerHTML = `
          <div class="alert alert-success text-center">
            <h4>${responseData.message || 'Registration Successful!'}</h4>
            <p>${responseData.instructions || 'Please check your email for further instructions on how to proceed.'}</p>
          </div>
        `;
      } else if (response.status === 422) {
        // Handle validation errors
        const errorData = await response.json();
        if (formMessage && errorData.errors) {
          formMessage.textContent = 'Please fix the following errors:';
          formMessage.className = 'alert alert-danger';
          const errorList = document.createElement('ul');
          for (const [field, messages] of Object.entries(errorData.errors)) {
            messages.forEach(message => {
              const listItem = document.createElement('li');
              listItem.textContent = message;
              errorList.appendChild(listItem);
            });
          }
          formMessage.appendChild(errorList);
        }
      } else {
        // Handle unexpected errors
        if (formMessage) {
          formMessage.textContent = 'An unexpected error occurred. Please try again later.';
          formMessage.className = 'alert alert-danger';
        }
      }
    } catch (error) {
      // Handle network or other errors
      if (formMessage) {
        formMessage.textContent = 'An error occurred. Please check your connection and try again.';
        formMessage.className = 'alert alert-danger';
      }
    }
  });
}