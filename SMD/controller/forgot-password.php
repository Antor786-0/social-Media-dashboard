<?php
session_start();
require_once("../model/db.php");

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit();   
}

    $email = $_POST['email'] ?? '';
    $email = trim($email);

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Please enter a valid email address!"]);
    exit();
}

     $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    exit();
}

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();
    echo json_encode(["success" => false, "message" => "Email not found!"]);
    exit();
}
    $stmt->close();
    $token = bin2hex(random_bytes(16));
    $expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));


     $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expires = ? WHERE email = ?");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    exit();
}

    $stmt->bind_param("sss", $token, $expires, $email);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "A reset link has been sent to your email!"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to generate reset link: " . $stmt->error
    ]);
}
    $stmt->close();
    $conn->close();
exit();
?>