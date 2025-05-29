<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require_once("../model/db.php"); // Ensure this file is clean: no echo, no space

// Prevent accidental output before JSON
ob_start();
session_start();
require_once("../model/db.php"); // Include your DB connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validate email
if (empty($email)) {
    echo json_encode(["success" => false, "message" => "Please enter your email."]);
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format."]);
    exit();
}

// Validate password
if (empty($password)) {
    echo json_encode(["success" => false, "message" => "Password is empty."]);
    exit();
}
if (strlen($password) < 6) {
    echo json_encode(["success" => false, "message" => "Password must be at least 6 characters."]);
    exit();
}

// Prepare and execute DB query
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows !== 1) {
    echo json_encode(["success" => false, "message" => "User not found with that email."]);
    $stmt->close();
    $conn->close();
    exit();
}

$stmt->bind_result($id, $username, $hashedPassword);
$stmt->fetch();

if (!password_verify($password, $hashedPassword)) {
    echo json_encode(["success" => false, "message" => "Incorrect password."]);
    $stmt->close();
    $conn->close();
    exit();
}

// Login successful, set session variables
$_SESSION['user_id'] = $id;
$_SESSION['username'] = $username;

echo json_encode(["success" => true, "message" => "Login successful!"]);

$stmt->close();
$conn->close();
exit();
?>
