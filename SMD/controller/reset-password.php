<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Simple validation
    if ($newPassword !== $confirmPassword) {
        $_SESSION['message'] = "Passwords don't match!";
        $_SESSION['message_color'] = "red";
        header("Location: ../reset-password.html");
        exit();
    }

    if (strlen($newPassword) < 6) {
        $_SESSION['message'] = "Password must be at least 6 characters!";
        $_SESSION['message_color'] = "red";
        header("Location: ../reset-password.html");
        exit();
    }

    // Store success message
    $_SESSION['message'] = "Password reset successfully!";
    $_SESSION['message_color'] = "green";

    // Redirect to login page after 1.5 seconds
    header("Refresh: 1.5; URL=../login.html");
    exit();
}
?>