document.getElementById('signupForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = document.getElementById('signupForm');
  const formData = new FormData(form);

  const password = formData.get('password');
  const confirmPassword = formData.get('confirmPassword');

  if (password !== confirmPassword) {
    document.getElementById('message').textContent = "Passwords don't match!";
    return;
  }

  if (password.length < 6) {
    document.getElementById('message').textContent = "Password must be at least 6 characters!";
    return;
  }

  fetch('../controller/signup.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('message').textContent = data;
  })
  .catch(error => {
    document.getElementById('message').textContent = "Error: " + error;
  });
});
