<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>
<link rel="stylesheet" href="../assets/css/addevent.css">



<?php
include '../includes/config.php';
$errors = [];
$title = $description = $location = $event_date = $start_time = $duration = $event_type = $price = "";
$event_name_to_delete = "";
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'add';
$deleteMessage = "";

// Add Event Functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    // Validation
    if (empty($_POST["title"])) $errors[] = "Event title is required";
    else $title = $_POST["title"];

    if (empty($_POST["description"])) $errors[] = "Event description is required";
    else $description = $_POST["description"];

    if (empty($_POST["location"])) $errors[] = "Event location is required";
    else $location = $_POST["location"];

    if (empty($_POST["event_date"])) $errors[] = "Event date is required";
    else $event_date = $_POST["event_date"];

    if (empty($_POST["start_time"])) $errors[] = "Start time is required";
    else $start_time = $_POST["start_time"];

    if (empty($_POST["duration"])) $errors[] = "Duration is required";
    else $duration = $_POST["duration"];

    if (empty($_POST["event_type"])) $errors[] = "Event type is required";
    else $event_type = $_POST["event_type"];

    $price = $_POST["price"] ?? 0;
    if ($event_type == "Paid" && empty($_POST["price"])) {
        $errors[] = "Price is required for paid events";
    }

    // Image upload
    $target_dir = "../assets/media/event/event-background-image/";
    $image_path = "";

    if (!empty($_FILES["event_image"]["name"])) {
        $target_file = $target_dir . basename($_FILES["event_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["event_image"]["tmp_name"]);

        if ($check === false) $errors[] = "File is not an image.";
        if ($_FILES["event_image"]["size"] > 5000000) $errors[] = "File too large. Max 5MB.";
        if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) $errors[] = "Only JPG, JPEG, PNG allowed.";

        if (empty($errors)) {
            $new_filename = uniqid() . '.' . $imageFileType;
            $target_file = $target_dir . $new_filename;
            if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                $errors[] = "Error uploading file.";
            }
        }
    } else {
        $errors[] = "Event image is required";
    }

    // Database insert
    if (empty($errors)) {
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO events (title, description, location, event_date, start_time, duration, event_type, price, image_path) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$title, $description, $location, $event_date, $start_time, $duration, $event_type, $price, $image_path]);

            session_start();
            $_SESSION['success_message'] = "Event added successfully!";
           
            
            echo "<script>alert('Event added successfully!');</script>";
            header("Location: event.php");
            // exit();
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

// Delete Event Functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_event'])) {
    if (empty($_POST["event_name_to_delete"])) {
        $errors[] = "Event name is required for deletion";
    } else {
        $event_name_to_delete = $_POST["event_name_to_delete"];
        
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // First check if the event exists
            $check_sql = "SELECT COUNT(*) FROM events WHERE title = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->execute([$event_name_to_delete]);
            $count = $check_stmt->fetchColumn();
            
            if ($count > 0) {
                // Get event details for email
                $event_sql = "SELECT * FROM events WHERE title = ?";
                $event_stmt = $conn->prepare($event_sql);
                $event_stmt->execute([$event_name_to_delete]);
                $event_data = $event_stmt->fetch(PDO::FETCH_ASSOC);
                
                // Check if there are registered attendees for this event
                $attendees_sql = "SELECT * FROM event_reg WHERE title = ?";
                $attendees_stmt = $conn->prepare($attendees_sql);
                $attendees_stmt->execute([$event_name_to_delete]);
                $registered_attendees = $attendees_stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // If there are attendees, send cancellation emails
                if (count($registered_attendees) > 0) {
                    // Set up PHPMailer
                    require 'PHPMailer/src/Exception.php';
                    require 'PHPMailer/src/PHPMailer.php';
                    require 'PHPMailer/src/SMTP.php';
                    
                    $mail = new PHPMailer(true);
                    
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'sivmalishan@gmail.com';
                    $mail->Password   = 'ovdefveiczfsawtc';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;
                    
                    // Format date for better readability
                    $formatted_date = date('l, F j, Y', strtotime($event_data['event_date']));
                    $formatted_time = date('g:i A', strtotime($event_data['start_time']));
                    
                    // Send email to each registered attendee
                    foreach ($registered_attendees as $attendee) {
                        try {
                            $mail->clearAddresses();
                            $mail->addAddress($attendee['email']);
                            $mail->isHTML(true);
                            $mail->Subject = "Important: Event Cancellation - {$event_name_to_delete}";
                            
                            // Create HTML email content
                            $mail->Body = "
                            <!DOCTYPE html>
                            <html>
                            <head>
                                <style>
                                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                                    .container { max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
                                    .header { background-color: #e74c3c; color: white; padding: 20px; text-align: center; }
                                    .content { padding: 20px; background-color: #fafafa; }
                                    .event-details { background-color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                                    h1, h2 { margin-top: 0; }
                                    .footer { background-color: #333; color: white; text-align: center; padding: 15px; font-size: 12px; }
                                    table { width: 100%; border-collapse: collapse; }
                                    td { padding: 8px; border-bottom: 1px solid #eee; }
                                    td:first-child { font-weight: bold; width: 140px; }
                                    .cancellation-notice { background-color: #f8d7da; border-left: 4px solid #e74c3c; padding: 10px; margin: 10px 0; }
                                </style>
                            </head>
                            <body>
                                <div class='container'>
                                    <div class='header'>
                                        <h1>Event Cancellation Notice</h1>
                                    </div>
                                    
                                    <div class='content'>
                                        <p>Dear <b>{$attendee['namec']}</b>,</p>
                                        
                                        <div class='cancellation-notice'>
                                            <p><strong>Important:</strong> We regret to inform you that the following event has been cancelled:</p>
                                        </div>
                                        
                                        <div class='event-details'>
                                            <h2>Event Details</h2>
                                            <table>
                                                <tr>
                                                    <td>Event:</td>
                                                    <td><b>{$event_name_to_delete}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Date:</td>
                                                    <td><b>{$formatted_date}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Time:</td>
                                                    <td><b>{$formatted_time}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Location:</td>
                                                    <td>{$event_data['location']}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        
                                        <p>We sincerely apologize for any inconvenience this may cause. If you have any questions or concerns, please don't hesitate to contact our support team.</p>
                                        
                                        <p>If you made any payment for this event, a full refund will be processed within 5-7 business days.</p>
                                        
                                        <p>Thank you for your understanding.</p>
                                    </div>
                                    
                                    <div class='footer'>
                                        <p>© " . date('Y') . " Secret Berry Resort. All rights reserved.</p>
                                        <p>1234 Resort Avenue, Paradise Island</p>
                                    </div>
                                </div>
                            </body>
                            </html>
                            ";
                            
                            // Plain text alternative
                            $mail->AltBody = "EVENT CANCELLATION NOTICE\n\n" .
                                            "Dear {$attendee['namec']},\n\n" .
                                            "We regret to inform you that the following event has been cancelled:\n\n" .
                                            "EVENT DETAILS:\n" .
                                            "Event: {$event_name_to_delete}\n" .
                                            "Date: {$formatted_date}\n" .
                                            "Time: {$formatted_time}\n" .
                                            "Location: {$event_data['location']}\n\n" .
                                            "We sincerely apologize for any inconvenience this may cause. If you have any questions or concerns, please don't hesitate to contact our support team.\n\n" .
                                            "If you made any payment for this event, a full refund will be processed within 5-7 business days.\n\n" .
                                            "Thank you for your understanding.\n\n" .
                                            "© " . date('Y') . " Secret Berry Resort. All rights reserved.";
                            
                            $mail->send();
                            
                        } catch (Exception $e) {
                            // Log the error but continue with other emails
                            error_log("Failed to send cancellation email to {$attendee['email']}: {$mail->ErrorInfo}");
                        }
                    }
                }
                
                // Now delete the registrations for this event
                $delete_reg_sql = "DELETE FROM event_reg WHERE title = ?";
                $delete_reg_stmt = $conn->prepare($delete_reg_sql);
                $delete_reg_stmt->execute([$event_name_to_delete]);
                
                // Finally delete the event itself
                $delete_sql = "DELETE FROM events WHERE title = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->execute([$event_name_to_delete]);
                
                $deleteMessage = "Event '{$event_name_to_delete}' has been deleted successfully!";
                
                if (count($registered_attendees) > 0) {
                    $deleteMessage .= " Cancellation emails have been sent to " . count($registered_attendees) . " registered attendee(s).";
                }
                
                echo "<script>alert('{$deleteMessage}');</script>";
                header("Location: event.php");
                exit;
                
            } else {
                $errors[] = "Event '{$event_name_to_delete}' not found!";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Events</title>
    <link rel="stylesheet" href="Assets/css/addevent.css" />
</head>
<body>

<div class="header-container">
    <div class="section__container" id="home">
        <div class="container-text">
            <h1>Event Management</h1>
            <div class="page-path">
                <p><span>Admin ></span> events</p>
            </div>
        </div>
    </div>
</div>

<div class="admin-buttons">
    <button class="mode-btn <?php echo ($mode == 'add') ? 'active' : ''; ?>" onclick="window.location.href='?mode=add'">Add Event</button>
    <button class="mode-btn <?php echo ($mode == 'delete') ? 'active' : ''; ?>" onclick="window.location.href='?mode=delete'">Delete Event</button>
</div>

<div class="form-container">
    <?php if ($mode == 'add'): ?>
        <h2 class="form-title">Create New Event</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>?mode=add" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Event Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>" required />
            </div>

            <div class="form-group">
                <label for="description">Event Description</label>
                <textarea id="description" name="description" required><?= htmlspecialchars($description) ?></textarea>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?= htmlspecialchars($location) ?>" required />
            </div>

            <div class="form-group">
                <label for="event_date">Event Date</label>
                <input type="date" id="event_date" name="event_date" value="<?= htmlspecialchars($event_date) ?>" required />
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" id="start_time" name="start_time" value="<?= htmlspecialchars($start_time) ?>" required />
            </div>

            <div class="form-group">
                <label for="duration">Duration (hours)</label>
                <input type="number" id="duration" name="duration" value="<?= htmlspecialchars($duration) ?>" min="1" required />
            </div>

            <div class="form-group">
                <label for="event_type">Event Type</label>
                <select id="event_type" name="event_type" required onchange="togglePriceField()">
                    <option value="">-- Select Event Type --</option>
                    <option value="Free" <?= ($event_type == 'Free') ? 'selected' : '' ?>>Free</option>
                    <option value="Paid" <?= ($event_type == 'Paid') ? 'selected' : '' ?>>Paid</option>
                </select>
            </div>

            <div class="form-group" id="price-group" style="display: <?= ($event_type == 'Paid') ? 'block' : 'none'; ?>">
                <label for="price">Price ($)</label>
                <input type="number" id="price" name="price" value="<?= htmlspecialchars($price) ?>" min="0" step="0.01" />
            </div>

            <div class="form-group">
                <label for="event_image">Event Image</label>
                <input type="file" id="event_image" name="event_image" accept="image/*" required />
            </div>

            <button type="submit" name="add_event" class="submit-btn">Add Event</button>
        </form>
    <?php else: ?>
        <h2 class="form-title">Delete Event</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($deleteMessage)): ?>
            <div class="success-message">
                <?= htmlspecialchars($deleteMessage) ?>
            </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>?mode=delete" method="post">
            <div class="form-group">
                <label for="event_name_to_delete">Event Name to Delete</label>
                <input type="text" id="event_name_to_delete" name="event_name_to_delete" value="<?= htmlspecialchars($event_name_to_delete) ?>" required />
            </div>

            <button type="submit" name="delete_event" class="delete-btn">Delete Event</button>
        </form>
    <?php endif; ?>
</div>

<script src="../assets/js/addevent.js"></script>
</body>
</html>