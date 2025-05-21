<?php
declare(strict_types=1);

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "../includes/config.php";

// Initialize message variable for feedback
$message = '';
$message_type = ''; // 'success' or 'error'

/**
 * Handles the deletion of a booking by ID.
 *
 * @param mysqli $conn Database connection
 * @param int $booking_id ID of the booking to delete
 * @return array<string, string> Message and message type
 */
function handleDeleteRequest(mysqli $conn, int $booking_id): array
{
    $stmtCheck = $conn->prepare("SELECT booking_id FROM room_bookings WHERE booking_id = ?");
    if (!$stmtCheck) {
        return ['message' => 'Prepare failed: ' . $conn->error, 'message_type' => 'error'];
    }
    $stmtCheck->bind_param("i", $booking_id);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows === 0) {
        $stmtCheck->close();
        return ['message' => 'No booking found with the given ID.', 'message_type' => 'error'];
    }

    $stmt = $conn->prepare("DELETE FROM room_bookings WHERE booking_id = ?");
    if (!$stmt) {
        $stmtCheck->close();
        return ['message' => 'Prepare failed: ' . $conn->error, 'message_type' => 'error'];
    }
    $stmt->bind_param("i", $booking_id);
    $success = $stmt->execute();
    $stmt->close();
    $stmtCheck->close();

    return $success
        ? ['message' => 'Booking deleted successfully.', 'message_type' => 'success']
        : ['message' => 'Error deleting booking: ' . $conn->error, 'message_type' => 'error'];
}

/**
 * Handles the update of a booking.
 *
 * @param mysqli $conn Database connection
 * @param int $booking_id ID of the booking to update
 * @param array<string, mixed> $data Form data
 * @return array<string, string> Message and message type
 */
function handleUpdateRequest(mysqli $conn, int $booking_id, array $data): array
{
    // Log raw POST data
    error_log("Raw POST data: " . print_r($data, true));

    // Sanitize input data
    $full_name = trim((string)($data['full_name'] ?? ''));
    $email = trim((string)($data['email'] ?? ''));
    $phone_number = trim((string)($data['phone_number'] ?? ''));
    $room_type = trim((string)($data['room_type'] ?? ''));
    $checkin_date = (string)($data['checkin_date'] ?? '');
    $checkout_date = (string)($data['checkout_date'] ?? '');
    $adult_count = (int)($data['adult_count'] ?? 0);
    $children_count = (int)($data['children_count'] ?? 0);
    $room_price = (float)($data['room_price'] ?? 0.00);
    $special_requests = isset($data['special_requests']) ? trim((string)$data['special_requests']) : null;

    // Validate required fields
    if (empty($full_name) || empty($email) || empty($phone_number) || empty($room_type) ||
        empty($checkin_date) || empty($checkout_date)) {
        return ['message' => 'Missing required fields.', 'message_type' => 'error'];
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['message' => 'Invalid email format.', 'message_type' => 'error'];
    }

    // Validate dates
    try {
        $checkin = new DateTime($checkin_date);
        $checkout = new DateTime($checkout_date);
        if ($checkout <= $checkin) {
            return ['message' => 'Check-out date must be after check-in date.', 'message_type' => 'error'];
        }
        $checkin_date = $checkin->format('Y-m-d');
        $checkout_date = $checkout->format('Y-m-d');
    } catch (Exception $e) {
        error_log("Invalid date format: " . $e->getMessage());
        return ['message' => 'Invalid date format.', 'message_type' => 'error'];
    }

    // Check if booking exists
    $stmtCheck = $conn->prepare("SELECT booking_id FROM room_bookings WHERE booking_id = ?");
    if (!$stmtCheck) {
        return ['message' => 'Prepare failed: ' . $conn->error, 'message_type' => 'error'];
    }
    $stmtCheck->bind_param("i", $booking_id);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows === 0) {
        $stmtCheck->close();
        return ['message' => 'No booking found with the given ID.', 'message_type' => 'error'];
    }
    $stmtCheck->close();

    // Update query (excluding payment_status)
    $query = "UPDATE room_bookings 
              SET full_name = ?, email = ?, phone_number = ?, room_type = ?, 
                  checkin_date = ?, checkout_date = ?, adult_count = ?, 
                  children_count = ?, room_price = ?, special_requests = ? 
              WHERE booking_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return ['message' => 'Prepare failed: ' . $conn->error, 'message_type' => 'error'];
    }

    $stmt->bind_param(
        "ssssssiidsi",
        $full_name,
        $email,
        $phone_number,
        $room_type,
        $checkin_date,
        $checkout_date,
        $adult_count,
        $children_count,
        $room_price,
        $special_requests,
        $booking_id
    );

    $success = $stmt->execute();
    if (!$success) {
        $error = $conn->error;
        $stmt->close();
        error_log("Execute failed: $error");
        return ['message' => 'Error updating booking: ' . $error, 'message_type' => 'error'];
    }

    $affected_rows = $stmt->affected_rows;
    $stmt->close();

    if ($affected_rows > 0) {
        return ['message' => 'Booking updated successfully.', 'message_type' => 'success'];
    }

    return ['message' => 'No changes made to the booking.', 'message_type' => 'error'];
}

// Handle Delete Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_booking_id'])) {
    $booking_id = (int)$_POST['delete_booking_id'];
    ['message' => $message, 'message_type' => $message_type] = handleDeleteRequest($conn, $booking_id);
}

// Handle Update Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];
    ['message' => $message, 'message_type' => $message_type] = handleUpdateRequest($conn, $booking_id, $_POST);
}

// Fetch all room bookings
$query = "SELECT booking_id, full_name, email, phone_number, room_type, checkin_date, checkout_date, 
          adult_count, children_count, payment_status, room_price, special_requests, booking_time 
          FROM room_bookings";
$result = $conn->query($query);
if (!$result) {
    $message = 'Error fetching bookings: ' . $conn->error;
    $message_type = 'error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .section-admin{
            display: flex;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #343a40;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .nav-links {
            flex-grow: 1;
            margin-left: 0px;
        }
        .nav-links i{
            margin-right: 10px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background: #495057;
            border-radius: 5px;
        }
        .logout {
            margin-top: auto;
            padding-bottom: 20px;
        }
        .logout i{
            margin-right: 20px;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
        .iconAdmin i{
            font-size: 60px;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            border: 3px solid white;
            border-radius: 50%;
            padding: 20px;
        }
    </style>
</head>
<body>
<?php require_once "../includes/adminDashboardNavBar.php"; ?>

<div class="content">
    <div class="container py-4">
        <h2 class="mb-4">Manage Room Bookings</h2>
        <?php if ($message !== ''): ?>
            <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?>">
                <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Room Type</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Adults</th>
                    <th>Children</th>
                    <th>Payment Status</th>
                    <th>Price</th>
                    <th>Special Requests</th>
                    <th>Booking Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    $index = 0;
                    while ($row = $result->fetch_assoc()) {
                        $index++;
                        ?>
                        <tr data-booking-id="<?php echo htmlspecialchars((string)$row['booking_id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <td><?php echo htmlspecialchars((string)$index, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['phone_number'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['room_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars(date('F d, Y', strtotime($row['checkin_date'])), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars(date('F d, Y', strtotime($row['checkout_date'])), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string)$row['adult_count'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string)$row['children_count'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_status'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format((float)$row['room_price'], 2), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['special_requests'] ?? 'None', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars(date('F d, Y H:i', strtotime($row['booking_time'])), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#editBookingModal">Edit</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                    <input type="hidden" name="delete_booking_id" value="<?php echo htmlspecialchars((string)$row['booking_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="14" class="text-center">No bookings found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="editBookingForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookingModalLabel">Edit Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="editBookingId" />
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required />
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required />
                    </div>
                    <div class="mb-3">
                        <label for="room_type" class="form-label">Room Type</label>
                        <input type="text" class="form-control" id="room_type" name="room_type" required />
                    </div>
                    <div class="mb-3">
                        <label for="checkin_date" class="form-label">Check-in Date</label>
                        <input type="date" class="form-control" id="checkin_date" name="checkin_date" required />
                    </div>
                    <div class="mb-3">
                        <label for="checkout_date" class="form-label">Check-out Date</label>
                        <input type="date" class="form-control" id="checkout_date" name="checkout_date" required />
                    </div>
                    <div class="mb-3">
                        <label for="adult_count" class="form-label">Adults</label>
                        <input type="number" class="form-control" id="adult_count" name="adult_count" min="0" required />
                    </div>
                    <div class="mb-3">
                        <label for="children_count" class="form-label">Children</label>
                        <input type="number" class="form-control" id="children_count" name="children_count" min="0" required />
                    </div>
                    <div class="mb-3">
                        <label for="room_price" class="form-label">Room Price</label>
                        <input type="number" step="0.01" class="form-control" id="room_price" name="room_price" min="0" required />
                    </div>
                    <div class="mb-3">
                        <label for="special_requests" class="form-label">Special Requests</label>
                        <textarea class="form-control" id="special_requests" name="special_requests" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const editModal = new bootstrap.Modal(document.getElementById('editBookingModal'));

    $('.editBtn').click(function() {
        const row = $(this).closest('tr');
        const bookingId = row.data('booking-id');

        $('#editBookingId').val(bookingId);
        $('#full_name').val(row.find('td:eq(1)').text());
        $('#email').val(row.find('td:eq(2)').text());
        $('#phone_number').val(row.find('td:eq(3)').text());
        $('#room_type').val(row.find('td:eq(4)').text());

        function formatDateForInput(dateStr) {
            try {
                const date = new Date(dateStr);
                if (isNaN(date)) {
                    console.log('Invalid date string:', dateStr);
                    return '';
                }
                return date.toISOString().split('T')[0];
            } catch (e) {
                console.log('Date parsing error:', e.message);
                return '';
            }
        }

        $('#checkin_date').val(formatDateForInput(row.find('td:eq(5)').text()));
        $('#checkout_date').val(formatDateForInput(row.find('td:eq(6)').text()));
        $('#adult_count').val(row.find('td:eq(7)').text());
        $('#children_count').val(row.find('td:eq(8)').text());

        const priceText = row.find('td:eq(10)').text().replace(/[^\d.]/g, '');
        $('#room_price').val(parseFloat(priceText).toFixed(2));

        const special = row.find('td:eq(11)').text();
        $('#special_requests').val(special === 'None' ? '' : special);

        editModal.show();
    });

    $('#editBookingForm').on('submit', function(e) {
        const checkinDate = $('#checkin_date').val();
        const checkoutDate = $('#checkout_date').val();
        if (checkinDate && checkoutDate && new Date(checkoutDate) <= new Date(checkinDate)) {
            e.preventDefault();
            alert('Check-out date must be after check-in date.');
            console.log('Invalid dates:', { checkinDate, checkoutDate });
            return false;
        }
    });
});
</script>

</body>
</html>
<?php
$conn->close();
?>
