<?php
require_once "../../includes/config.php";

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = intval($_POST['userId'] ?? 0);
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? '');

    if ($userId > 0 && $full_name && $email && $role) {
        $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, role = ? WHERE userId = ?");
        $stmt->bind_param("sssi", $full_name, $email, $role, $userId);
        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'User updated successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to update user.'];
        }
        $stmt->close();
    } else {
        $response = ['success' => false, 'message' => 'Invalid input data.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

$conn->close();
echo json_encode($response);
exit;
