<?php
session_start();

header('Content-Type: application/json');

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
$albumName = isset($_POST['album']) ? htmlspecialchars($_POST['album']) : 'Untitled Album';
$isCollaborative = isset($_POST['collaborative']) && $_POST['collaborative'] === 'true';

// Validate file type (only allow images)
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($photo['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Only image files (JPEG, PNG, GIF, WEBP) are allowed.']);
    exit();
}

// Generate a unique filename
$uniqueName = uniqid() . "_" . basename($photo['name']);
$targetFile = $targetDir . $uniqueName;

// Move the uploaded file
if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
    // Store file path in session
    if (!isset($_SESSION['albums'])) {
        $_SESSION['albums'] = [];
  [];
    }
    if (!isset($_SESSION['albums'][$albumName])) {
        $_SESSION['albums'][$albumName] = [];
    }
    $_SESSION['albums'][$albumName][] = [
        'path' => $targetFile,
        'collaborative' => $isCollaborative
    ];

    echo json_encode([
        'success' => true,
        'filePath' => $targetFile,
        'album' => $albumName
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error uploading the file.']);
}
?>