document.addEventListener('DOMContentLoaded', function() {
  // Set username from localStorage
  const email = localStorage.getItem('currentUser');
  if (email) {
    document.getElementById('username').textContent = email.split('@')[0];
  }
  
  // Handle block list addition
  document.getElementById('addBlock').addEventListener('click', function() {
    const username = document.getElementById('blockList').value;
    if (!username) {
      showMessage('Please enter a username to block', 'error');
      return;
    }

    showMessage(`${username} added to block list`, 'success');
    document.getElementById('blockList').value = '';
  });
  
  // Handle form submission
  document.getElementById('privacyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const defaultAudience = document.getElementById('defaultAudience').value;
    
    // Show success message
    showMessage('Privacy settings updated successfully!', 'success');
  });
  
  function showMessage(text, type) {
    const messageDiv = document.getElementById('message');
    messageDiv.textContent = text;
    messageDiv.className = 'message ' + (type === 'success' ? 'success' : 'error');
  }
});