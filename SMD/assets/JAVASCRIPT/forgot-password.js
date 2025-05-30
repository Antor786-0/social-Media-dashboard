document.getElementById('forgotForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const emailInput = document.getElementById('email');
  const messageDiv = document.getElementById('message');
  const email = emailInput.value.trim();

if (!email) {
    messageDiv.textContent = "Please enter your email.";
    messageDiv.style.color = "red";
    return;
  }

  fetch('../controller/forgot-password.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `email=${encodeURIComponent(email)}`
  })
  .then(response => response.json())
  .then(data => {
if (data.success) {
      messageDiv.textContent = data.message;
      messageDiv.style.color = "green";
      setTimeout(() => {
        window.location.href = 'reset-password.html';
      }, 2000);
  } else {
          messageDiv.textContent = data.message;
          messageDiv.style.color = "red";
         }
  })
  .catch(err => {
    messageDiv.textContent = "An error occurred. Please try again.";
    messageDiv.style.color = "red";
    console.error(err);
  });
});