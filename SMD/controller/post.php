<?php
session_start();
require_once("../model/db.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "You must be logged in to post!"]);
    exit();
}

$userId = $_SESSION['user_id'];
$content = trim($_POST['postContent'] ?? '');
$isScheduled = isset($_POST['schedulePost']) && $_POST['schedulePost'] === 'on';
$postTime = trim($_POST['postTime'] ?? '');

// Validate content
if ($content === '') {
    echo json_encode(["success" => false, "message" => "Please write something to post!"]);
    exit();
}

// Validate scheduled time if scheduled
if ($isScheduled && $postTime === '') {
    echo json_encode(["success" => false, "message" => "Please select a time for scheduled post!"]);
    exit();
}

$createdAt = date('Y-m-d H:i:s');
$scheduledAt = $isScheduled ? $postTime : null;

// Insert into DB
$stmt = $conn->prepare("INSERT INTO posts (user_id, content, created_at, scheduled_at) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    exit();
}

$stmt->bind_param("isss", $userId, $content, $createdAt, $scheduledAt);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Post created successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
exit();
?>
