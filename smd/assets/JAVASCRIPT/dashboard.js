// JAVASCRIPT/dashboard.js
document.addEventListener('DOMContentLoaded', function() {
    // Set username from localStorage
    const email = localStorage.getItem('currentUser');
    if (email) {
      document.getElementById('username').textContent = email.split('@')[0];
    }
    
    // Set some demo data
    document.getElementById('postCount').textContent = '12';
    document.getElementById('friendCount').textContent = '87';
    document.getElementById('photoCount').textContent = '45';
    
    // Highlight current page in sidebar
    const currentPage = window.location.pathname.split('/').pop();
    const links = document.querySelectorAll('.sidebar a');
    
    links.forEach(link => {
      if (link.getAttribute('href') === currentPage) {
        link.parentElement.classList.add('active');
      }
    });
  });