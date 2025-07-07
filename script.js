// Smooth Scroll for all anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute("href"));
    if (target) {
      target.scrollIntoView({ behavior: "smooth" });
    }
  });
});

// Sticky Navbar
window.addEventListener('scroll', () => {
  const navbar = document.querySelector('.navbar');
  navbar.classList.toggle('sticky', window.scrollY > 60);
});

// Test alert for donation buttons
document.querySelectorAll('.btn.green').forEach(button => {
  button.addEventListener('click', () => {
    alert("Thank you for your interest in donating! Functionality coming soon.");
  });
});
