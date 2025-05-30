<?php
session_start();
require_once("../model/db.php"); 

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['error' => 'Invalid request method.']);
    exit();
}

      $newPassword = $_POST['newPassword'] ?? '';
      $confirmPassword = $_POST['confirmPassword'] ?? '';
if ($newPassword !== $confirmPassword) {
    echo json_encode(['error' => "Passwords don't match!"]);
    exit();
}

if (strlen($newPassword) < 6) {
    echo json_encode(['error' => "Password must be at least 6 characters!"]);
    exit();
}

if (!isset($_SESSION['resetEmail'])) {
    echo json_encode(['error' => 'Session expired or invalid request. Please try again.']);
    exit();
}

      $email = $_SESSION['resetEmail'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
if (!$stmt) {
    echo json_encode(['error' => 'Database error: prepare failed.']);
    exit();
}
     $stmt->bind_param("ss", $hashedPassword, $email);

if ($stmt->execute()) {

    unset($_SESSION['resetEmail']);
    echo json_encode(['success' => 'Password reset successfully!']);
  } else {
          echo json_encode(['error' => 'Failed to reset password. Please try again.']);
         }

$stmt->close();
$conn->close();
exit();
?>