<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $captcha = $_POST['captcha'] ?? '';

    // Simple CAPTCHA validation
    if (trim($captcha) !== '5') {
        $_SESSION['message'] = "Incorrect CAPTCHA answer!";
        $_SESSION['message_type'] = "error";
        header("Location: ../contact.html");
        exit();
    }

    // Basic email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Please enter a valid email address!";
        $_SESSION['message_type'] = "error";
        header("Location: ../contact.html");
        exit();
    }

    // In a real app, you would send the data to a server or email
    // For demo, store in session to simulate processing
    $_SESSION['contact_submission'] = [
        'name' => $name,
        'email' => $email,
        'message' => $message
    ];

    // Store success message
    $_SESSION['message'] = "Message sent successfully!";
    $_SESSION['message_type'] = "success";

    // Redirect back to contact page
    header("Location: ../contact.html");
    exit();
}
?>