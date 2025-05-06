// JAVASCRIPT/login.js
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    // Simple validation
    if (!email || !password) {
      document.getElementById('message').textContent = "Please fill in all fields!";
      return;
    }
    // Validate password: must be exactly 6 digits
    const isValidPassword = /^\d{6}$/.test(password);
    if (!isValidPassword) {
        message.textContent = "Password must be exactly 6 digits!";
        return;
    }
    // In a real app, you would verify with server
    console.log('Login attempt:', email, password);
    
    // For demo, check if email is the one we "signed up" with
    const tempEmail = localStorage.getItem('tempEmail');
    if (email === tempEmail) {
      // Store login state
      localStorage.setItem('isLoggedIn', 'true');
      localStorage.setItem('currentUser', email);
      
      // Redirect to dashboard
      window.location.href = 'dashboard.html';
    } else {
      document.getElementById('message').textContent = "Invalid credentials!";
    }
  });