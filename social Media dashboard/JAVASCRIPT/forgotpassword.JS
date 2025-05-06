function resetRequestValidation() {
  let email = document.getElementById("forgotEmail").value;
  let message = document.getElementById("forgotMessage");

  if (email === "") {
    alert("Email must needed");
    return false;
  }

  let user = JSON.parse(localStorage.getItem(email));

  if (user) {
    let token = Math.random().toString(36).substr(2, 10);
    localStorage.setItem("resetToken_" + token, email);
    message.style.color = "green";
    message.innerHTML = `Reset link: <a href="reset-password.html?token=${token}">Click here to reset</a>`;
    return true;
  } else {
    message.style.color = "red";
    message.textContent = "No account found with this email.";
    return false;
  }
}

let resetBtn = document.getElementById("resetBtn");
resetBtn.addEventListener("click", (event) => {
  event.preventDefault();
  resetRequestValidation();
});
