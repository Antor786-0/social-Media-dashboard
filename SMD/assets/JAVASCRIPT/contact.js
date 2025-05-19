document.addEventListener('DOMContentLoaded', function() {
  // Set username from localStorage or keep as Guest
  const email = localStorage.getItem('currentUser');
  document.getElementById('username').textContent = email ? email.split('@')[0] : 'Guest';
  
  // Handle form submission
  document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const emailInput = document.getElementById('email').value;
    const message = document.getElementById('message').value;
    const captcha = document.getElementById('captcha').value;
    
    // Simple CAPTCHA validation
    if (captcha.trim() !== '5') {
      showMessage('Incorrect CAPTCHA answer!', 'error');
      return;
    }
    
    // In a real app, you would send this to a server
    console.log('Contact form submitted:', { name, email: emailInput, message });
    
    // Show success message
    showMessage('Message sent successfully!', 'success');
    
    // Clear form
    document.getElementById('contactForm').reset();
  });
  
  function showMessage(text, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;
    messageDiv.textContent = text;
    document.querySelector('.content').appendChild(messageDiv);
    
    // Remove message after 3 seconds
    setTimeout(() => {
      messageDiv.remove();
    }, 3000);
  }
});