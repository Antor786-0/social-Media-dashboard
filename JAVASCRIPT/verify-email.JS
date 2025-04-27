function verifyEmail() {
  const params = new URLSearchParams(window.location.search);
  const email = params.get("email");
  const code = params.get("verificationCode");

  const user = JSON.parse(localStorage.getItem(email));
  if (user && user.verificationCode === code) {
    user.verified = true;
    localStorage.setItem(email, JSON.stringify(user));
    alert("Email verified successfully!");
    window.location.href = "login.html";
  } else {
    alert("Invalid verification link.");
  }
}
