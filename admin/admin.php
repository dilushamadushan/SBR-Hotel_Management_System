<?php
declare(strict_types=1);

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include('../includes/config.php');

// Initialize variables for dashboard data
$total_users = 0;
$total_bookings = 0;
$available_rooms = 0;
$recent_activities = [];
$message = '';
$message_type = ''; // 'success' or 'error'

// Fetch total users
$stmt_users = $conn->prepare("SELECT COUNT(*) as count FROM users");
if ($stmt_users) {
    $stmt_users->execute();
    $result_users = $stmt_users->get_result();
    $total_users = $result_users->fetch_assoc()['count'];
    $stmt_users->close();
} else {
    error_log("Error preparing users query: " . $conn->error);
    $message = 'Error fetching user count.';
    $message_type = 'error';
}

// Fetch total bookings
$stmt_bookings = $conn->prepare("SELECT COUNT(*) as count FROM room_bookings");
if ($stmt_bookings) {
    $stmt_bookings->execute();
    $result_bookings = $stmt_bookings->get_result();
    $total_bookings = $result_bookings->fetch_assoc()['count'];
    $stmt_bookings->close();
} else {
    error_log("Error preparing bookings query: " . $conn->error);
    $message = 'Error fetching booking count.';
    $message_type = 'error';
}

// Fetch available rooms
$stmt_rooms = $conn->prepare("SELECT COUNT(*) as count FROM rooms WHERE status = ?");
if ($stmt_rooms) {
    $status = 'Available';
    $stmt_rooms->bind_param("s", $status);
    $stmt_rooms->execute();
    $result_rooms = $stmt_rooms->get_result();
    $available_rooms = $result_rooms->fetch_assoc()['count'];
    $stmt_rooms->close();
} else {
    error_log("Error preparing rooms query: " . $conn->error);
    $message = 'Error fetching room count.';
    $message_type = 'error';
}

// Fetch recent activities (last 5 bookings)
$stmt_activities = $conn->prepare("SELECT full_name, room_type, booking_time 
                                   FROM room_bookings 
                                   ORDER BY booking_time DESC 
                                   LIMIT 5");
if ($stmt_activities) {
    $stmt_activities->execute();
    $result_activities = $stmt_activities->get_result();
    while ($row = $result_activities->fetch_assoc()) {
        $recent_activities[] = $row;
    }
    $stmt_activities->close();
} else {
    error_log("Error preparing activities query: " . $conn->error);
    $message = 'Error fetching recent activities.';
    $message_type = 'error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard-navbar.css">
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
            margin-left: 0;
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
    </style>
</head>
<body>
<!-- Sidebar -->
<?php require_once "../includes/adminDashboardNavBar.php"; ?>

<!-- Main Content -->
<div class="content">
    <div id="dashboard" class="content-section active">
        <h2 class="mb-4">Dashboard</h2>
        <?php if ($message !== ''): ?>
            <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?>">
                <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text fs-4"><?php echo htmlspecialchars((string)$total_users, ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Bookings</h5>
                        <p class="card-text fs-4"><?php echo htmlspecialchars((string)$total_bookings, ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Available Rooms</h5>
                        <p class="card-text fs-4"><?php echo htmlspecialchars((string)$available_rooms, ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h4>Recent Activity</h4>
            <ul class="list-group">
                <?php if (count($recent_activities) > 0): ?>
                    <?php foreach ($recent_activities as $activity): ?>
                        <li class="list-group-item">
                            <?php
                            $name = htmlspecialchars($activity['full_name'], ENT_QUOTES, 'UTF-8');
                            $room = htmlspecialchars($activity['room_type'], ENT_QUOTES, 'UTF-8');
                            $time = date('F d, Y H:i', strtotime($activity['booking_time']));
                            echo "User $name booked a $room room on $time.";
                            ?>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">No recent activities found.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>


</body>
</html>
<?php
$conn->close();
?>