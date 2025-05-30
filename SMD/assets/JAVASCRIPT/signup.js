document.getElementById('signupForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = document.getElementById('signupForm');
  const message = document.getElementById('message');
  const formData = new FormData(form);

  const password = formData.get('password');
  const confirmPassword = formData.get('confirmPassword');

  message.style.color = "red";

if (password !== confirmPassword) {
    message.textContent = "Passwords don't match!";
    return;
  }

if (password.length < 6) {
    message.textContent = "Password must be at least 6 characters!";
    return;
  }

  fetch('../controller/signup.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    message.textContent = data;
if (data.includes("successful")) {
      message.style.color = "green";
      setTimeout(() => {
        window.location.href = 'login.html';
      }, 1500);
    }
  })
  .catch(error => {
    message.textContent = "Error: " + error;
  });
});
