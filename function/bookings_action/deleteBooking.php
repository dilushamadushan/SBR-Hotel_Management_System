<?php
// Include your database connection file
require_once "../../includes/config.php";

// Check if the booking ID is provided via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);

    // Prepare and execute the DELETE query
    $query = "DELETE FROM room_bookings WHERE booking_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Booking deleted successfully."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error deleting booking: " . $conn->error
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request. Booking ID is required."
    ]);
}

$conn->close();
?>
