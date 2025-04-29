function handleSignup() {
  const username = document.getElementById('username').value.trim();
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirmPassword').value;
  const message = document.getElementById('message');

  if (!username || !email || !password || !confirmPassword) {
    message.style.color = 'red';
    message.textContent = 'All fields are required.';
    return;
  }

  if (password.length < 6) {
    message.style.color = 'red';
    message.textContent = 'Password must be at least 6 characters.';
    return;
  }

  if (password !== confirmPassword) {
    message.style.color = 'red';
    message.textContent = 'Passwords do not match.';
    return;
  }

  const verificationCode = Math.random().toString(36).substr(2, 6);
  const user = { username, email, password, verified: false, verificationCode };
  localStorage.setItem(email, JSON.stringify(user));

  message.style.color = 'green';
  message.textContent = `Signup successful! Verification sent to ${email}.`;

  setTimeout(() => {
    window.location.href = `verify-email.html?email=${encodeURIComponent(email)}&verificationCode=${verificationCode}`;
  }, 1000);
}
