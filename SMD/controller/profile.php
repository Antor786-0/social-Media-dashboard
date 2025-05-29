<?php
session_start();
require_once("../model/db.php"); // Your database connection

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'You must be logged in to edit profile.']);
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch current user info (optional, if needed for validation)
// $stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
// $stmt->bind_param("i", $userId);
// $stmt->execute();
// $result = $stmt->get_result();
// $user = $result->fetch_assoc();

$displayName = trim($_POST['displayName'] ?? '');
$bio = trim($_POST['bio'] ?? '');
$theme = $_POST['theme'] ?? 'blue';

// Validate inputs (simple example)
if (strlen($displayName) > 100) {
    echo json_encode(['error' => 'Display name must be less than 100 characters.']);
    exit();
}

if (strlen($theme) > 20) {
    echo json_encode(['error' => 'Invalid theme selected.']);
    exit();
}

$profileImageFilename = null;
$uploadDir = '../assets/uploads/';

if (isset($_FILES['profileUpload']) && $_FILES['profileUpload']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profileUpload']['tmp_name'];
    $fileName = basename($_FILES['profileUpload']['name']);
    $fileSize = $_FILES['profileUpload']['size'];
    $fileType = mime_content_type($fileTmpPath);

    // Validate file type (accept only images)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['error' => 'Only JPG, PNG, GIF, or WEBP images are allowed.']);
        exit();
    }

    // Optional: Validate file size (e.g., max 2MB)
    if ($fileSize > 2 * 1024 * 1024) {
        echo json_encode(['error' => 'Image size should be less than 2MB.']);
        exit();
    }

    // Create unique filename to prevent overwrite
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = 'profile_' . $userId . '_' . time() . '.' . $ext;
    $destPath = $uploadDir . $newFileName;

    if (!move_uploaded_file($fileTmpPath, $destPath)) {
        echo json_encode(['error' => 'There was an error moving the uploaded file.']);
        exit();
    }

    $profileImageFilename = $newFileName;
}

// Build the SQL query dynamically based on whether profile image was uploaded
if ($profileImageFilename) {
    $stmt = $conn->prepare("UPDATE users SET display_name = ?, bio = ?, theme = ?, profile_image = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $displayName, $bio, $theme, $profileImageFilename, $userId);
} else {
    $stmt = $conn->prepare("UPDATE users SET display_name = ?, bio = ?, theme = ? WHERE id = ?");
    $stmt->bind_param("sssi", $displayName, $bio, $theme, $userId);
}

if ($stmt->execute()) {
    $response = ['success' => 'Profile updated successfully!'];
    if ($profileImageFilename) {
        $response['filename'] = $profileImageFilename;
    }
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Failed to update profile. Please try again.']);
}

$stmt->close();
$conn->close();
?>
