<?php
session_start();
include('../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data
    $room_type = $_POST['room_type'] ?? '';
    $user_full_name = $_POST['name'] ?? '';
    $email          = $_POST['email'] ?? '';
    $phone_number   = $_POST['phone'] ?? '';
    $check_in_date  = $_POST['checkin'] ?? '';
    $check_out_date = $_POST['checkout'] ?? '';
    $adults         = $_POST['adults'] ?? 0;
    $children       = $_POST['children'] ?? 0;
    $card_number    = $_POST['card_number'] ?? '';
    $expiry_date    = $_POST['expiry_date'] ?? '';
    $cvv            = $_POST['cvv'] ?? '';
    $card_holder    = $_POST['card_holder'] ?? '';
    $special_requests = $_POST['requests'] ?? '';

    // Set default statuses
    $payment_status  = "Paid";         // Simulated; real logic would depend on payment gateway
    $booking_status  = "Booked";      // Could be 'Confirmed' after admin approval

    // INSERT into DB
    $sql = "INSERT INTO booking_details ( room_type, user_full_name, email, phone_number, check_in_date, check_out_date, adults, children, special_requests, payment_status, booking_status)
            VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssiisss",
        $room_type, $user_full_name, $email, $phone_number,
        $check_in_date, $check_out_date, $adults, $children,
        $special_requests, $payment_status, $booking_status
    );

    if ($stmt->execute()) {
        $_SESSION['booking_success'] = true;
        $stmt->close();
        $conn->close();
        header("Location: room-catalogue.php");
        exit();
    } else {
        echo "<p style='color:red;'>❌ Error: " . $stmt->error . "</p>";
    }
}
?>
