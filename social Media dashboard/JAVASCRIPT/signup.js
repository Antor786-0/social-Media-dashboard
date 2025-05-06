// JAVASCRIPT/signup.js
document.getElementById('signupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    // Simple validation
    if (password !== confirmPassword) {
      document.getElementById('message').textContent = "Passwords don't match!";
      return;
    }
    
    if (password.length < 6) {
      document.getElementById('message').textContent = "Password must be at least 6 characters!";
      return;
    }
    
    // In a real app, you would send this to a server
    console.log('Signup data:', { username, email, password });
    
    // Store in localStorage for demo purposes
    localStorage.setItem('tempEmail', email);
    
    // Redirect to verification page
    window.location.href = 'verify-email.html';
  });