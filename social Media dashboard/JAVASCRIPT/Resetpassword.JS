let urlParams = new URLSearchParams(window.location.search);
let token = urlParams.get("token");
let email = localStorage.getItem("resetToken_" + token);
let message = document.getElementById("resetMessage");

if (!email) {
  document.querySelector('.box').innerHTML = '<p class="message" style="color: red;">Invalid or expired token.</p>';
}

function newPasswordValidation() {
  let newPassword = document.getElementById("newPassword").value;

  if (newPassword === "") {
    alert("New password must needed");
    return false;
  }

  let user = JSON.parse(localStorage.getItem(email));

  if (user) {
    user.password = newPassword;
    localStorage.setItem(email, JSON.stringify(user));
    localStorage.removeItem("resetToken_" + token);
    message.style.color = "green";
    message.textContent = "Password successfully reset!";
    return true;
  } else {
    message.style.color = "red";
    message.textContent = "Something went wrong.";
    return false;
  }
}

let resetPasswordBtn = document.getElementById("resetPasswordBtn");
resetPasswordBtn.addEventListener("click", (event) => {
  event.preventDefault();
  newPasswordValidation();
});
