<?php
session_start();
require_once("../model/db.php"); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['message'] = "You must be logged in to change privacy settings.";
        $_SESSION['message_type'] = "error";
        header("Location: ../index.html");
        exit();
    }

    $userId = $_SESSION['user_id'];

    if (isset($_POST['blockList'])) {
        // Block user flow
        $usernameToBlock = trim($_POST['blockList']);

        if (empty($usernameToBlock)) {
            $_SESSION['message'] = "Please enter a username to block.";
            $_SESSION['message_type'] = "error";
            header("Location: ../privacy.html");
            exit();
        }

        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $usernameToBlock);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($blockedUserId);
            $stmt->fetch();

            // Check if already blocked to prevent duplicates
            $checkStmt = $conn->prepare("SELECT id FROM blocks WHERE user_id = ? AND blocked_user_id = ?");
            $checkStmt->bind_param("ii", $userId, $blockedUserId);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows === 0) {
                // Insert into blocks table
                $insertStmt = $conn->prepare("INSERT INTO blocks (user_id, blocked_user_id) VALUES (?, ?)");
                $insertStmt->bind_param("ii", $userId, $blockedUserId);

                if ($insertStmt->execute()) {
                    $_SESSION['message'] = "$usernameToBlock has been blocked successfully.";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Failed to block user. Try again.";
                    $_SESSION['message_type'] = "error";
                }
                $insertStmt->close();
            } else {
                $_SESSION['message'] = "User is already blocked.";
                $_SESSION['message_type'] = "error";
            }

            $checkStmt->close();
        } else {
            $_SESSION['message'] = "Username not found.";
            $_SESSION['message_type'] = "error";
        }

        $stmt->close();
        $conn->close();

        header("Location: ../privacy.html");
        exit();

    } elseif (isset($_POST['defaultAudience'])) {
        // Update default audience
        $defaultAudience = $_POST['defaultAudience'];

        $allowedValues = ['public', 'friends', 'only-me'];
        if (!in_array($defaultAudience, $allowedValues)) {
            $_SESSION['message'] = "Invalid audience selected.";
            $_SESSION['message_type'] = "error";
            header("Location: ../privacy.html");
            exit();
        }

        $stmt = $conn->prepare("UPDATE users SET default_audience = ? WHERE id = ?");
        $stmt->bind_param("si", $defaultAudience, $userId);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Privacy settings updated successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to update privacy settings.";
            $_SESSION['message_type'] = "error";
        }

        $stmt->close();
        $conn->close();

        header("Location: ../privacy.html");
        exit();

    } else {
        // No relevant POST data found
        $_SESSION['message'] = "Invalid request.";
        $_SESSION['message_type'] = "error";
        header("Location: ../privacy.html");
        exit();
    }
} else {
    header("Location: ../privacy.html");
    exit();
}
?>
