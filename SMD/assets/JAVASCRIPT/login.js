document.getElementById('loginForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const messageDiv = document.getElementById('message');

  if (!validateEmail() || !validatePassword()) return;

  const formData = new FormData(this);

  fetch('../controller/login.php', {
    method: 'POST',
    body: formData
  })
    .then(response => {
      if (!response.ok) throw new Error("HTTP status " + response.status);
      return response.json();
    })
    .then(data => {
      if (data.success) {
        messageDiv.textContent = data.message;
        messageDiv.style.color = "green";
        setTimeout(() => {
          window.location.href = '../view/dashboard.html';
        }, 1500);
      } else {
        messageDiv.textContent = data.message;
        messageDiv.style.color = "red";
      }
    })
    .catch(error => {
      messageDiv.textContent = "An error occurred. Please try again.";
      messageDiv.style.color = "red";
      console.error("Login error:", error); // Log the actual error in console
    });
});
