<?php
session_start();
header('Content-Type: application/json');

// Include database connection
require_once("../model/db.php");

// Define the target directory
$targetDir = "../assets/uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// Check if a file was uploaded
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] === UPLOAD_ERR_NO_FILE) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
    exit();
}

$photo = $_FILES['photo'];
$albumName = isset($_POST['album']) ? trim($_POST['album']) : 'Untitled Album';
$isCollaborative = isset($_POST['collaborative']) && $_POST['collaborative'] === 'true';

// Validate file type (only allow images)
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/heic'];
if (!in_array($photo['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Only image files (JPEG, PNG, GIF, WEBP) are allowed.']);
    exit();
}

// Generate a unique filename
$uniqueName = uniqid() . "_" . basename($photo['name']);
$targetFile = $targetDir . $uniqueName;

// Move the uploaded file
if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
    // Get user id from session (assuming user logged in and user id is stored)
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
        exit();
    }

    // Check if album exists, if not create it
    // Assuming you have an 'albums' table with columns: id, user_id, album_name, collaborative (bool)
    $stmt = $conn->prepare("SELECT id FROM albums WHERE user_id = ? AND album_name = ?");
    $stmt->bind_param("is", $userId, $albumName);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($albumId);
        $stmt->fetch();
    } else {
        // Create album
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO albums (user_id, album_name, collaborative) VALUES (?, ?, ?)");
        $collabInt = $isCollaborative ? 1 : 0;
        $stmt->bind_param("isi", $userId, $albumName, $collabInt);
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Failed to create album.']);
            exit();
        }
        $albumId = $stmt->insert_id;
    }
    $stmt->close();

    // Insert photo record into photos table: columns: id, album_id, photo_path, uploaded_at
    $stmt = $conn->prepare("INSERT INTO photos (album_id, photo_path, uploaded_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $albumId, $targetFile);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'filePath' => $targetFile,
            'album' => $albumName
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save photo in database.']);
    }
    $stmt->close();
    $conn->close();

} else {
    echo json_encode(['success' => false, 'message' => 'Error uploading the file.']);
}
?>
