<?php
session_start(); // Start session to store messages

// Function to validate post content
function validatePostContent($content) {
    if (empty(trim($content))) {
        return "Please write something to post!";
    }
    return true;
}

// Function to validate scheduled post time
function validatePostTime($isScheduled, $postTime) {
    if ($isScheduled && empty($postTime)) {
        return "Please select a time for scheduled post!";
    }
    return true;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = isset($_POST['postContent']) ? trim($_POST['postContent']) : '';
    $isScheduled = isset($_POST['schedulePost']) && $_POST['schedulePost'] === 'on';
    $postTime = isset($_POST['postTime']) ? trim($_POST['postTime']) : '';

    // Validate inputs
    $contentResult = validatePostContent($content);
    $timeResult = validatePostTime($isScheduled, $postTime);

    // Check for validation errors
    if ($contentResult !== true) {
        $_SESSION['message'] = $contentResult;
        $_SESSION['message_type'] = 'error';
    } elseif ($timeResult !== true) {
        $_SESSION['message'] = $timeResult;
        $_SESSION['message_type'] = 'error';
    } else {
        // Validation passed; store post (placeholder for database logic)
        // In a real app, save to database here
        $_SESSION['message'] = 'Post created successfully!';
        $_SESSION['message_type'] = 'success';
        
        // Redirect to dashboard (mimicking JavaScript redirect behavior)
        header('Location: ../view/dashboard.html');
        exit();
    }

    // Redirect back to post form with error message
    header('Location: ../post.html');
    exit();
} else {
    // Redirect to post form if accessed directly
    header('Location: ../post.html');
    exit();
}
?>