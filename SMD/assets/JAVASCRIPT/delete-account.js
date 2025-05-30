document.addEventListener('DOMContentLoaded', function() {
  const email = localStorage.getItem('currentUser');
if (email) {
    document.getElementById('username').textContent = email.split('@')[0];
  }
  const messageDiv = document.getElementById('message');
  const modal = document.getElementById('deactivationModal');
  const twoFactorInput = document.getElementById('twoFactorCode');
  document.getElementById('exportData').addEventListener('click', function() {

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

  document.getElementById('startDeactivation').addEventListener('click', function() {
    modal.style.display = 'flex';
  });

  document.getElementById('cancelDeactivation').addEventListener('click', function() {
    modal.style.display = 'none';
    twoFactorInput.value = '';
  });
  document.getElementById('confirmDeactivation').addEventListener('click', function() {
    const twoFactorCode = twoFactorInput.value.trim();
if (!twoFactorCode) {
      showMessage('Please enter your 2FA code.', 'error');
      return;
    }
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