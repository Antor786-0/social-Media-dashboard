<?php
session_start();
require_once("../model/db.php");

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit;
}

// Get input JSON data
$input = json_decode(file_get_contents('php://input'), true);
$twoFactorCode = trim($input['twoFactorCode'] ?? '');

if (empty($twoFactorCode)) {
    echo json_encode(["success" => false, "message" => "2FA code is required."]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Here you can validate 2FA code from DB or service. For demo, assume it matches.
$stmt = $conn->prepare("SELECT two_factor_code FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($dbTwoFactorCode);
$stmt->fetch();
$stmt->close();

if ($dbTwoFactorCode !== $twoFactorCode) {
    echo json_encode(["success" => false, "message" => "Invalid 2FA code."]);
    exit;
}

// Schedule deactivation date 30 days from now
$deactivationDate = date("Y-m-d H:i:s", strtotime("+30 days"));

// Update user table to mark deactivation requested
$stmt = $conn->prepare("UPDATE users SET deactivation_requested = 1, deactivation_date = ? WHERE id = ?");
$stmt->bind_param("si", $deactivationDate, $user_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Account deactivation scheduled successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to schedule deactivation: " . $stmt->error]);
}

$stmt->close();
$conn->close();
exit;
?>
