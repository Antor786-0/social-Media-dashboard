const urlParams = new URLSearchParams(window.location.search);
const token = urlParams.get("token");
const email = localStorage.getItem("resetToken_" + token);
const message = document.getElementById("resetMessage");

if (!email) {
  document.querySelector('.box').innerHTML = '<p class="message" style="color: red;">Invalid or expired token.</p>';
}

function resetPassword() {
  const newPassword = document.getElementById("newPassword").value;
  const user = JSON.parse(localStorage.getItem(email));

  if (user) {
    user.password = newPassword;
    localStorage.setItem(email, JSON.stringify(user));
    localStorage.removeItem("resetToken_" + token);
    message.style.color = "green";
    message.textContent = "Password successfully reset!";
  } else {
    message.style.color = "red";
    message.textContent = "Something went wrong.";
  }
}
