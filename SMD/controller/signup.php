<?php
session_start();
require_once("../model/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirmPassword'] ?? '';

if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "All fields are required!";
        exit();
    }

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit();
    }

if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

if (strlen($password) < 6) {
        echo "Password must be at least 6 characters!";
        exit();
    }
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
if ($check->num_rows > 0) {
        echo "Email is already registered!";
        $check->close();
        exit();
    }
    $check->close();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
if (!$stmt) {
        echo "DB Error: " . $conn->error;
        exit();
    }

    $stmt->bind_param("sss", $username, $email, $hashed_password);

if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
            echo "Registration failed: " . $stmt->error;
           }

    $stmt->close();
    $conn->close();
    } else {
             echo "Invalid request.";
           }
?>
