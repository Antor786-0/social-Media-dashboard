// JAVASCRIPT/login.js
function email(){
  const email = document.getElementById('email').value;
    if (email === "") {
      document.getElementById('message').textContent = "Please enter your email.";
      return false;
    }
  
    if (!email.includes("@") || !email.includes(".")) {
      document.getElementById('message').textContent = "Email must contain '@' and '.'";
      return false;
    }
  
    const atPosition = email.indexOf("@");
    const dotPosition = email.lastIndexOf(".");
  
    if (
      atPosition < 1 ||
      dotPosition < atPosition + 2 ||
      dotPosition + 1 >= email.length
    ) {
      document.getElementById('message').textContent = "Invalid email format.";
      return false;
    }
    return true;
}
function password(){
  const password = document.getElementById('password').value;
  if(password===""){
    document.getElementById('message').textContent = "Password is empty";
    return false;
  }
  if (password.length < 6) {
    document.getElementById('message').textContent = "Password must be at least 6 characters";
    return false;
  }
  return true;
}
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if(email() && password()){
      window.location.href="../view/dashboard.html";
    } 
    });