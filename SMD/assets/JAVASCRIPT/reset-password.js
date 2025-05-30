document.getElementById('resetForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const messageDiv = document.getElementById('message');
  const newPassword = document.getElementById('newPassword').value.trim();
  const confirmPassword = document.getElementById('confirmPassword').value.trim();

if (newPassword !== confirmPassword) {
    messageDiv.style.color = 'red';
    messageDiv.textContent = "Passwords don't match!";
    return;
  }

if (newPassword.length < 6) {
    messageDiv.style.color = 'red';
    messageDiv.textContent = "Password must be at least 6 characters!";
    return;
  }

  const formData = new URLSearchParams();
  formData.append('newPassword', newPassword);
  formData.append('confirmPassword', confirmPassword);

  fetch('../controller/reset-password.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData.toString()
  })
  .then(response => response.json())
  .then(data => {
if (data.error) {
      messageDiv.style.color = 'red';
      messageDiv.textContent = data.error;
  } else if (data.success) {
      messageDiv.style.color = 'green';
      messageDiv.textContent = data.success;
      setTimeout(() => {
        window.location.href = 'login.html';
      }, 1500);
    }
  })
  .catch(() => {
    messageDiv.style.color = 'red';
    messageDiv.textContent = 'An error occurred. Please try again.';
  });
});
