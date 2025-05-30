document.addEventListener('DOMContentLoaded', function() {
    const email = localStorage.getItem('currentUser');
if (email) {
      document.getElementById('username').textContent = email.split('@')[0];
    }
    document.getElementById('postCount').textContent = '12';
    document.getElementById('friendCount').textContent = '87';
    document.getElementById('photoCount').textContent = '45';

            const currentPage = window.location.pathname.split('/').pop();
            const links = document.querySelectorAll('.sidebar a');
    
    links.forEach(link => {
if (link.getAttribute('href') === currentPage) {
        link.parentElement.classList.add('active');
      }
    });
  });