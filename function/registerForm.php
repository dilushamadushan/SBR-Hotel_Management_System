<?php
session_start();
require '../includes/config.php';

header('Content-Type: application/json');  // Respond with JSON

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = trim($_POST['registerName'] ?? '');
    $email = filter_var(trim($_POST['registerEmail'] ?? ''), FILTER_SANITIZE_EMAIL);
    $mobile = trim($_POST['registerMobile'] ?? '');
    $address = trim($_POST['registerAddress'] ?? '');
    $password = $_POST['registerPassword'] ?? '';

    // Validate required fields
    if (empty($name) || empty($email) || empty($mobile) || empty($address) || empty($password)) {
        $response['message'] = "Please fill all required fields.";
        echo json_encode($response);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Invalid email format.";
        echo json_encode($response);
        exit;
    }

    if (strlen($password) < 6) {
        $response['message'] = "Password must be at least 6 characters.";
        echo json_encode($response);
        exit;
    }

    if (!isset($_FILES['user_image'])) {
        $response['message'] = "Please upload a user image.";
        echo json_encode($response);
        exit;
    }

    if ($_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../upload/';

        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $response['message'] = "Failed to create directory for uploads.";
                echo json_encode($response);
                exit;
            }
        }

        $fileTmpPath = $_FILES['user_image']['tmp_name'];
        $fileName = basename($_FILES['user_image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExt, $allowedExts)) {
            $response['message'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            echo json_encode($response);
            exit;
        }

        $newFileName = uniqid('img_', true) . '.' . $fileExt;
        $destPath = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            $response['message'] = "Error uploading the file.";
            echo json_encode($response);
            exit;
        }
    } else {
        $response['message'] = "File upload error code: " . $_FILES['user_image']['error'];
        echo json_encode($response);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (full_name, email, contactNo, address, imgPath, password, role) VALUES (?, ?, ?, ?, ?, ?, 'user')";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        $response['message'] = "Prepare failed: " . $conn->error;
        echo json_encode($response);
        exit;
    }

    $imgPathForDb = 'upload/' . $newFileName;

    $stmt->bind_param("ssssss", $name, $email, $mobile, $address, $imgPathForDb, $hashedPassword);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Registration successful! You can now <a href='../pages/login.php'>login</a>.";
    } else {
        if ($conn->errno === 1062) {
            $response['message'] = "This email is already registered.";
        } else {
            $response['message'] = "Error: " . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();

} else {
    $response['message'] = "Invalid request.";
}

echo json_encode($response);
exit;
