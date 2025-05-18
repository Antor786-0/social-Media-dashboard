<?php
session_start();
// File upload 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Simple validation
    if ($password !== $confirmPassword) {
        $_SESSION['message'] = "Passwords don't match!";
        header("Location: ../signup.html");
        exit();
    }

    if (strlen($password) < 6) {
        $_SESSION['message'] = "Password must be at least 6 characters!";
        header("Location: ../signup.html");
        exit();
    }


    // Store email in session for demo purposes
    $_SESSION['tempEmail'] = $email;

    // Redirect to verification page
    header("Location: ../verify-email.html");
    exit();
}
?>