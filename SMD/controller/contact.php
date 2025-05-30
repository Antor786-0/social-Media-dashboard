<?php
session_start();
include '../db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = trim($_POST['name'] ?? '');
          $email = trim($_POST['email'] ?? '');
      $message = trim($_POST['message'] ?? '');
    $captcha = trim($_POST['captcha'] ?? '');

if ($captcha !== '5') {
        header("Location: ../view/contact.html?flash=" . urlencode("Incorrect CAPTCHA!") . "&type=error");
        exit();
    }
 
if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../view/contact.html?flash=" . urlencode("Please fill all fields correctly!") . "&type=error");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
        header("Location: ../view/contact.html?flash=" . urlencode("Message sent successfully!") . "&type=success");
    } else {
            header("Location: ../view/contact.html?flash=" . urlencode("Failed to submit message.") . "&type=error");
           }

    $stmt->close();
    $conn->close();
    exit();
}
?>