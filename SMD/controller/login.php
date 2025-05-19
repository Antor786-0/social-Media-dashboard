<?php
session_start(); // Start session to store error messages

// Function to validate email
function validateEmail($email) {
    if (empty($email)) {
        return "Please enter your email.";
    }

    if (strpos($email, '@') === false || strpos($email, '.') === false) {
        return "Email must contain '@' and '.'";
    }

    $atPosition = strpos($email, '@');
    $dotPosition = strrpos($email, '.');

    if (
        $atPosition < 1 ||
        $dotPosition < $atPosition + 2 ||
        $dotPosition + 1 >= strlen($email)
    ) {
        return "Invalid email format.";
    }

    return true;
}

// Function to validate password
function validatePassword($password) {
    if (empty($password)) {
        return "Password is empty";
    }

    if (strlen($password) < 6) {
        return "Password must be at least 6 characters";
    }

    return true;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validate inputs
    $emailResult = validateEmail($email);
    $passwordResult = validatePassword($password);

    // Check for validation errors
    if ($emailResult !== true) {
        $_SESSION['message'] = $emailResult;
    } elseif ($passwordResult !== true) {
        $_SESSION['message'] = $passwordResult;
    } else {
        // Validation passed; proceed with authentication
        // Replace with actual authentication (e.g., database check)
        header('Location: ../view/dashboard.html');
        exit();
    }

    // Redirect back to login page with error message
    header('Location: ../index.html');
    exit();
} else {
    // Redirect to login page if accessed directly
    header('Location: ../index.html');
    exit();
}
?>