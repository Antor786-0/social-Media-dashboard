function login() {
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const message = document.getElementById("message");

  if (!email || !password) {
    message.style.color = "red";
    message.textContent = "Please enter both email and password.";
    return;
  }

  message.style.color = "green";
  message.textContent = "Login successful!";
}
