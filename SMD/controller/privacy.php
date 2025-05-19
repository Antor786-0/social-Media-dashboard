<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle block list addition
    if (isset($_POST['blockList']) && !empty(trim($_POST['blockList']))) {
        $username = trim($_POST['blockList']);
        // Store blocked username in session (or database in a real app)
        $_SESSION['blocked_users'] = $_SESSION['blocked_users'] ?? [];
        $_SESSION['blocked_users'][] = $username;
        $_SESSION['message'] = "$username added to block list";
        $_SESSION['message_type'] = "success";
    } elseif (isset($_POST['blockList']) && empty(trim($_POST['blockList']))) {
        $_SESSION['message'] = "Please enter a username to block";
        $_SESSION['message_type'] = "error";
    } else {
        // Handle privacy form submission
        $defaultAudience = $_POST['defaultAudience'] ?? 'public';
        // Store default audience in session (or database in a real app)
        $_SESSION['defaultAudience'] = $defaultAudience;
        $_SESSION['message'] = "Privacy settings updated successfully!";
        $_SESSION['message_type'] = "success";
    }

    // Redirect back to privacy page
    header("Location: ../privacy.html");
    exit();
}
?>