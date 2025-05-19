<?php
session_start();
echo "I am loaded";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $displayName = $_POST['displayName'] ?? '';
    $bio = $_POST['bio'] ?? '';
    $theme = $_POST['theme'] ?? '';
    $profilePhoto = $_FILES['profileUpload'] ?? null;
    $uploadOk = true;

    // Validate file
    if ($profilePhoto && $profilePhoto['name']) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($profilePhoto['type'], $allowedTypes)) {
            $_SESSION['message'] = "Invalid profile photo format! Only JPEG, PNG, or GIF allowed.";
            $_SESSION['message_type'] = "error";
            $uploadOk = false;
        }
    }

    if ($uploadOk) {
        // Save values in session (simulating a database)
        $_SESSION['displayName'] = $displayName;
        $_SESSION['bio'] = $bio;
        $_SESSION['theme'] = $theme;

        // Handle image upload
        if ($profilePhoto && $profilePhoto['name']) {
            $targetDir = "../assets/uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $uniqueName = uniqid() . "_" . basename($profilePhoto['name']);
            $targetFile = $targetDir . $uniqueName;

            if (move_uploaded_file($profilePhoto['tmp_name'], $targetFile)) {
                $_SESSION['profilePhoto'] = $targetFile;
            } else {
                $_SESSION['message'] = "Error uploading the profile photo.";
                $_SESSION['message_type'] = "error";
                header("Location: ../view/dashboard.html");
                exit();
            }
        }

        $_SESSION['message'] = "Profile updated successfully!";
        $_SESSION['message_type'] = "success";
    }

    header("Location: ../view/profile.php");
    exit();
}
?>
