// JAVASCRIPT/reset-password.js
document.getElementById('resetForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (newPassword !== confirmPassword) {
      document.getElementById('message').textContent = "Passwords don't match!";
      return;
    }
    
    if (newPassword.length < 6) {
      document.getElementById('message').textContent = "Password must be at least 6 characters!";
      return;
    }

    
    // Show success message
    document.getElementById('message').textContent = "Password reset successfully!";
    document.getElementById('message').style.color = "green";
    
    // Redirect to login page
    setTimeout(function() {
      window.location.href = 'login.html';
    }, 1500);
  });