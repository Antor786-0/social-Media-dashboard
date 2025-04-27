function requestReset() {
  const email = document.getElementById("forgotEmail").value;
  const message = document.getElementById("forgotMessage");
  const user = JSON.parse(localStorage.getItem(email));

  if (user) {
    const token = Math.random().toString(36).substr(2, 10);
    localStorage.setItem("resetToken_" + token, email);
    message.style.color = "green";
    message.innerHTML = `Reset link: <a href="reset-password.html?token=${token}">Click here to reset</a>`;
  } else {
    message.style.color = "red";
    message.textContent = "No account found with this email.";
  }
}
