function validateEmail() {
  const email = document.getElementById('email').value.trim();
  const messageDiv = document.getElementById('message');

if (email === "") {
    messageDiv.textContent = "Email is required.";
    messageDiv.style.color = "red";
    return false;
  }
  const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if (!pattern.test(email)) {
    messageDiv.textContent = "Invalid email format.";
    messageDiv.style.color = "red";
    return false;
  }
  return true;
}

function validatePassword() {
  const password = document.getElementById('password').value.trim();
  const messageDiv = document.getElementById('message');

if (password === "") {
    messageDiv.textContent = "Password is required.";
    messageDiv.style.color = "red";
    return false;
  }
if (password.length < 6) {
    messageDiv.textContent = "Password must be at least 6 characters.";
    messageDiv.style.color = "red";
    return false;
  }
  return true;
}

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
      console.error("Login error:", error);
    });
});
