document.addEventListener('DOMContentLoaded', function() {
  // Set username from localStorage
  const email = localStorage.getItem('currentUser');
  if (email) {
    document.getElementById('username').textContent = email.split('@')[0];
  }
  
  // Handle data export
  document.getElementById('exportData').addEventListener('click', function() {
    // In a real app, this would generate a download link
    showMessage('Data export requested. Check your email for the download link.', 'success');
  });
  
  // Handle deactivation start
  document.getElementById('startDeactivation').addEventListener('click', function() {
    document.getElementById('deactivationModal').style.display = 'flex';
  });
  
  // Handle modal cancellation
  document.getElementById('cancelDeactivation').addEventListener('click', function() {
    document.getElementById('deactivationModal').style.display = 'none';
  });
  
  // Handle deactivation confirmation
  document.getElementById('confirmDeactivation').addEventListener('click', function() {
    const twoFactorCode = document.getElementById('twoFactorCode').value;
    
    if (!twoFactorCode) {
      showMessage('Please enter 2FA code', 'error');
      return;
    }
    
    // In a real app, you would verify the 2FA code with a server
    console.log('Account deactivation confirmed with 2FA code:', twoFactorCode);
    
    // Show success message and redirect
    showMessage('Account scheduled for deactivation.', 'success');
    document.getElementById('deactivationModal').style.display = 'none';
    
    setTimeout(function() {
      localStorage.removeItem('isLoggedIn');
      localStorage.removeItem('currentUser');
      window.location.href = 'index.html';
    }, 1500);
  });
  
  function showMessage(text, type) {
    const messageDiv = document.getElementById('message');
    messageDiv.textContent = text;
    messageDiv.className = 'message ' + (type === 'success' ? 'success' : 'error');
  }
});