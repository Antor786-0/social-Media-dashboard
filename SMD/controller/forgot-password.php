<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';

    // Basic email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Please enter a valid email address!";
        $_SESSION['message_color'] = "red";
        header("Location: ../forgot-password.html");
        exit();
    }

    // Store email in session for demo purposes
    $_SESSION['resetEmail'] = $email;

    // Store success message
    $_SESSION['message'] = "Reset link sent to your email!";
    $_SESSION['message_color'] = "green";

    // Redirect to reset password page after 2 seconds
    header("Refresh: 2; URL=../reset-password.html");
    exit();
}
?>