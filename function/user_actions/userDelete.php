<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../../includes/config.php";

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete_id = intval($_POST['userId'] ?? 0);
    if ($delete_id > 0) {
        $stmt = $conn->prepare("DELETE FROM users WHERE userId = ?");
        if ($stmt) {
            $stmt->bind_param("i", $delete_id);
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'User deleted successfully.'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to delete user.'];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Failed to prepare SQL statement.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Invalid user ID.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

$conn->close();
echo json_encode($response);
exit;
