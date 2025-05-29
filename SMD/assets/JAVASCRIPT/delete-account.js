document.addEventListener('DOMContentLoaded', function() {
  // Show username from localStorage
  const email = localStorage.getItem('currentUser');
  if (email) {
    document.getElementById('username').textContent = email.split('@')[0];
  }

  const messageDiv = document.getElementById('message');
  const modal = document.getElementById('deactivationModal');
  const twoFactorInput = document.getElementById('twoFactorCode');

  // Export Data button click
  document.getElementById('exportData').addEventListener('click', function() {
    // Simulate request to backend to email/export data
    fetch('../controller/export_data.php', { method: 'POST', credentials: 'include' })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          showMessage('Data export requested. Check your email for the download link.', 'success');
        } else {
          showMessage('Failed to export data: ' + data.message, 'error');
        }
      })
      .catch(() => showMessage('Network error. Please try again.', 'error'));
  });

  // Show deactivation modal
  document.getElementById('startDeactivation').addEventListener('click', function() {
    modal.style.display = 'flex';
  });

  // Cancel deactivation
  document.getElementById('cancelDeactivation').addEventListener('click', function() {
    modal.style.display = 'none';
    twoFactorInput.value = '';
  });

  // Confirm deactivation
  document.getElementById('confirmDeactivation').addEventListener('click', function() {
    const twoFactorCode = twoFactorInput.value.trim();
    if (!twoFactorCode) {
      showMessage('Please enter your 2FA code.', 'error');
      return;
    }

    // Send deactivation request with 2FA code to backend
    fetch('../controller/deactivate_account.php', {
      method: 'POST',
      credentials: 'include',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ twoFactorCode })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          showMessage('Account scheduled for deactivation.', 'success');
          modal.style.display = 'none';

          // Clear localStorage and redirect after short delay
          setTimeout(() => {
            localStorage.removeItem('isLoggedIn');
            localStorage.removeItem('currentUser');
            window.location.href = '../index.php';
          }, 1500);
        } else {
          showMessage(data.message || 'Failed to schedule deactivation.', 'error');
        }
      })
      .catch(() => showMessage('Network error. Please try again.', 'error'));
  });

  function showMessage(text, type) {
    messageDiv.textContent = text;
    messageDiv.className = 'message ' + (type === 'success' ? 'success' : 'error');
  }
});
