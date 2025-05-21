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
 * Handles the deletion of a room by ID.
 *
 * @param mysqli $conn Database connection
 * @param int $room_id ID of the room to delete
 * @return array<string, string> Message and message type
 */
function handleDeleteRequest(mysqli $conn, int $room_id): array
{
    $stmtCheck = $conn->prepare("SELECT room_id FROM rooms WHERE room_id = ?");
    if (!$stmtCheck) {
        return ['message' => 'Prepare failed: ' . $conn->error, 'message_type' => 'error'];
    }
    $stmtCheck->bind_param("i", $room_id);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows === 0) {
        $stmtCheck->close();
        return ['message' => 'No room found with the given ID.', 'message_type' => 'error'];
    }

    $stmt = $conn->prepare("DELETE FROM rooms WHERE room_id = ?");
    if (!$stmt) {
        $stmtCheck->close();
        return ['message' => 'Prepare failed: ' . $conn->error, 'message_type' => 'error'];
    }
    $stmt->bind_param("i", $room_id);
    $success = $stmt->execute();
    $stmt->close();
    $stmtCheck->close();

    return $success
        ? ['message' => 'Room deleted successfully.', 'message_type' => 'success']
        : ['message' => 'Error deleting room: ' . $conn->error, 'message_type' => 'error'];
}

/**
 * Handles the update of a room.
 *
 * @param mysqli $conn Database connection
 * @param int $room_id ID of the room to update
 * @param array<string, mixed> $data Form data
 * @return array<string, string> Message and message type
 */
function handleUpdateRequest(mysqli $conn, int $room_id, array $data): array
{
    // Log raw POST data
    error_log("Raw POST data: " . print_r($data, true));

    // Sanitize input data
    $room_number = trim((string)($data['room_number'] ?? ''));
    $room_type = trim((string)($data['room_type'] ?? ''));
    $status = trim((string)($data['status'] ?? ''));

    // Validate required fields
    if (empty($room_number) || empty($room_type) || empty($status)) {
        return ['message' => 'Missing required fields.', 'message_type' => 'error'];
    }

    // Validate room_type
    $valid_types = ['Single', 'Double', 'Deluxe', 'Suite', 'Economy'];
    if (!in_array($room_type, $valid_types, true)) {
        return ['message' => 'Invalid room type.', 'message_type' => 'error'];
    }

    // Validate status
    $valid_statuses = ['Available', 'Occupied', 'Maintenance'];
    if (!in_array($status, $valid_statuses, true)) {
        return ['message' => 'Invalid status.', 'message_type' => 'error'];
    }

    // Check if room exists
    $stmtCheck = $conn->prepare("SELECT room_id FROM rooms WHERE room_id = ?");
    if (!$stmtCheck) {
        return ['message' => 'Prepare failed: ' . $conn->error, 'message_type' => 'error'];
    }
    $stmtCheck->bind_param("i", $room_id);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows === 0) {
        $stmtCheck->close();
        return ['message' => 'No room found with the given ID.', 'message_type' => 'error'];
    }
    $stmtCheck->close();

    // Check for duplicate room_number (excluding current room)
    $stmtDup = $conn->prepare("SELECT room_id FROM rooms WHERE room_number = ? AND room_id != ?");
    if (!$stmtDup) {
        return ['message' => 'Prepare failed: ' . $conn->error, 'message_type' => 'error'];
    }
    $stmtDup->bind_param("si", $room_number, $room_id);
    $stmtDup->execute();
    $resultDup = $stmtDup->get_result();
    if ($resultDup->num_rows > 0) {
        $stmtDup->close();
        return ['message' => 'Room number already exists.', 'message_type' => 'error'];
    }
    $stmtDup->close();

    // Update query
    $query = "UPDATE rooms SET room_number = ?, room_type = ?, status = ? WHERE room_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return ['message' => 'Prepare failed: ' . $conn->error, 'message_type' => 'error'];
    }

    $stmt->bind_param("sssi", $room_number, $room_type, $status, $room_id);

    $success = $stmt->execute();
    if (!$success) {
        $error = $conn->error;
        $stmt->close();
        error_log("Execute failed: $error");
        return ['message' => 'Error updating room: ' . $error, 'message_type' => 'error'];
    }

    $affected_rows = $stmt->affected_rows;
    $stmt->close();

    if ($affected_rows > 0) {
        return ['message' => 'Room updated successfully.', 'message_type' => 'success'];
    }

    return ['message' => 'No changes made to the room.', 'message_type' => 'error'];
}

// Handle Delete Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_room_id'])) {
    $room_id = (int)$_POST['delete_room_id'];
    ['message' => $message, 'message_type' => $message_type] = handleDeleteRequest($conn, $room_id);
}

// Handle Update Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['room_id'])) {
    $room_id = (int)$_POST['room_id'];
    ['message' => $message, 'message_type' => $message_type] = handleUpdateRequest($conn, $room_id, $_POST);
}

// Fetch all rooms
$query = "SELECT room_id, room_number, room_type, status FROM rooms";
$result = $conn->query($query);
if (!$result) {
    $message = 'Error fetching rooms: ' . $conn->error;
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
        .section-admin {
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
        .nav-links i {
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
        .logout i {
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
        .iconAdmin i {
            font-size: 60px;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            border: 3px solid white;
            border-radius: 50%;
            padding: 20px;
        }
        .alert {
            margin-bottom: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<?php require_once "../includes/adminDashboardNavBar.php"; ?>

<div class="content">
    <div class="container py-4">
        <h2 class="mb-4">Manage Rooms</h2>
        <?php if ($message !== ''): ?>
            <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?>">
                <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Room Number</th>
                    <th>Type</th>
                    <th>Status</th>
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
                        <tr data-room-id="<?php echo htmlspecialchars((string)$row['room_id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <td><?php echo htmlspecialchars((string)$index, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['room_number'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['room_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#editRoomModal">Edit</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                    <input type="hidden" name="delete_room_id" value="<?php echo htmlspecialchars((string)$row['room_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-center">No rooms found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="editRoomForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="room_id" id="editRoomId" />
                    <div class="mb-3">
                        <label for="room_number" class="form-label">Room Number</label>
                        <input type="text" class="form-control" id="room_number" name="room_number" required />
                    </div>
                    <div class="mb-3">
                        <label for="room_type" class="form-label">Room Type</label>
                        <select class="form-select" id="room_type" name="room_type" required>
                            <option value="Single">Single</option>
                            <option value="Double">Double</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="Suite">Suite</option>
                            <option value="Economy">Economy</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Available">Available</option>
                            <option value="Occupied">Occupied</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
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
    const editModal = new bootstrap.Modal(document.getElementById('editRoomModal'));

    $('.editBtn').click(function() {
        const row = $(this).closest('tr');
        const roomId = row.data('room-id');

        $('#editRoomId').val(roomId);
        $('#room_number').val(row.find('td:eq(1)').text());
        $('#room_type').val(row.find('td:eq(2)').text());
        $('#status').val(row.find('td:eq(3)').text());

        editModal.show();
    });

    $('#editRoomForm').on('submit', function(e) {
        const roomNumber = $('#room_number').val().trim();
        if (!roomNumber) {
            e.preventDefault();
            alert('Room number cannot be empty.');
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