<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "You are not logged in!"]);
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Directory where you want to save uploads
    $uploadDir = __DIR__ . "/../assets/uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (isset($_FILES['profileUpload']) && $_FILES['profileUpload']['error'] === UPLOAD_ERR_OK) {

        $fileTmpPath = $_FILES['profileUpload']['tmp_name'];
        $fileName = basename($_FILES['profileUpload']['name']);
        $fileSize = $_FILES['profileUpload']['size'];
        $fileType = $_FILES['profileUpload']['type'];

        // Optional: You can check file extension/type here for security
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'heic'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo json_encode(["error" => "Invalid file type. Only jpg, jpeg, png, gif allowed."]);
            exit;
        }

        // Generate new unique file name to avoid overwriting
        $newFileName = 'profile_' . $userId . '_' . time() . '.' . $fileExtension;

        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Success - you can save $newFileName to DB for user's profile photo if you want
            echo json_encode(["success" => "File uploaded successfully!", "filename" => $newFileName]);
        } else {
            echo json_encode(["error" => "Error moving uploaded file."]);
        }
    } else {
        echo json_encode(["error" => "Error uploading file. Please try again."]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
?>
