// JAVASCRIPT/verify-email.js
function verifyEmail() {
    // In a real app, this would check with server
    setTimeout(function() {
      document.getElementById('message').textContent = "Email verified successfully! Redirecting...";
      setTimeout(function() {
        window.location.href = 'dashboard.html';
      }, 2000);
    }, 1500);
  }
  
  document.getElementById('resendForm').addEventListener('submit', function(e) {
    e.preventDefault();
    document.getElementById('message').textContent = "Verification email resent!";
  });