// JAVASCRIPT/forgot-password.js
document.getElementById('forgotForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    
    // In a real app, you would send this to a server
    console.log('Password reset requested for:', email);
    
    // Store email for demo purposes
    localStorage.setItem('resetEmail', email);
    
    // Show success message
    document.getElementById('message').textContent = "Reset link sent to your email!";
    
    // In a real app, you would redirect to a page telling them to check their email
    // For demo, we'll let them click a link to go to reset page
    setTimeout(function() {
      window.location.href = 'reset-password.html';
    }, 2000);
  });