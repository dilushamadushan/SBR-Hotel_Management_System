<?php
session_start();
header('Content-Type: application/json');

// Enable error logging and hide errors from output (adjust for production)
ini_set('display_errors', 0); // Set to '1' during development for immediate visibility
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Validate the request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

require '../includes/config.php';

// Sanitize and validate inputs
$email = filter_var(trim($_POST['loginEmail'] ?? ''), FILTER_SANITIZE_EMAIL);
$password = trim($_POST['loginPassword'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters.']);
    exit;
}

// Prepare the SQL statement
$query = "SELECT userId, email, full_name, password, role FROM users WHERE email = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    $error = $conn->error;
    error_log("SQL Prepare Error: " . $error);
    echo json_encode(['success' => false, 'message' => 'Internal server error.', 'debug' => $error]);
    exit;
}

// Bind and execute
$stmt->bind_param("s", $email);
if (!$stmt->execute()) {
    $error = $stmt->error;
    error_log("SQL Execute Error: " . $error);
    echo json_encode(['success' => false, 'message' => 'Internal server error.', 'debug' => $error]);
    exit;
}

$result = $stmt->get_result();
if ($result === false) {
    $error = $conn->error;
    error_log("SQL Result Error: " . $error);
    echo json_encode(['success' => false, 'message' => 'Internal server error.', 'debug' => $error]);
    exit;
}

// Check if a user was found
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
        // Set session variables securely
        $_SESSION['user_id'] = $user['userId'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role']; // Assuming admin role for this example

        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Login successful.', 'role' => $user['role']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
}

// Clean up
$stmt->close();
$conn->close();
exit;


?>