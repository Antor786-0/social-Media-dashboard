<?php
session_start();
require_once("../model/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? 0;
    $album_name = trim($_POST['albumName'] ?? '');


if (!$user_id || $album_name === '') 
   {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
     exit;
   }

    $stmt = $conn->prepare("INSERT INTO albums (user_id, name) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $album_name);


if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Album created successfully']);
    } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create album']);
           }
    $stmt->close();
    $conn->close();
}
?>