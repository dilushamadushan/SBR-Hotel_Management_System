







<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include "../includes/config.php";
require_once '../includes/conn.php'; 


// Check if the table is empty
$check_sql = "SELECT COUNT(*) AS total FROM events";
$result = $conn->query($check_sql);
$row = $result->fetch_assoc();

if ($row['total'] == 0) {
    // Insert sample data
    $insert_sql = "INSERT INTO events (title, description, location, event_date, start_time, duration, event_type, price,image_path) VALUES
        ('Dancing Party', 'A big party dance with Stars.', 'New York', '2025-05-12', '10:00:00', 5, 'Paid', 'Free', '../assets/media/event/event-background-image/food.jpg'),
        ('Tech Conference', 'A big tech event for networking.', 'New York', '2025-05-12', '10:00:00', 5, 'Paid', 100.00, '../assets/media/event/event-background-image/techConference.jpg'),
        ('Music Fest', 'Enjoy live music performances.', 'Los Angeles', '2025-06-20', '18:00:00', 6, 'Free', 0.00, '../assets/media/event/event-background-image/MusicFestival.jpg'),
        ('Startup Meetup', 'Networking for startups.', 'San Francisco', '2025-07-08', '14:00:00', 3, 'Free', 0.00, '../assets/media/event/event-background-image/StartupMeetup.jpg'),
        ('Art Exhibition', 'Explore amazing art.', 'Paris', '2025-08-14', '09:00:00', 4, 'Paid', 25.00, '../assets/media/event/event-background-image/ArtExhibition.jpg'),
        ('Coding Bootcamp', 'Learn full-stack development.', 'Online', '2025-09-01', '08:00:00', 8, 'Paid', 299.00, '../assets/media/event/event-background-image/CodingBootcamp.jpg'),
        ('Gaming Tournament', 'Compete and win prizes!', 'Las Vegas', '2025-10-10', '12:00:00', 5, 'Paid', 50.00, '../assets/media/event/event-background-image/GamingTournament.jpg'),
        ('Film Festival', 'Watch and review films.', 'Toronto', '2025-11-05', '16:00:00', 5, 'Paid', 15.00, '../assets/media/event/event-background-image/FilmFestival.jpg'),
        ('Food Fair', 'Taste dishes from around the world.', 'London', '2025-12-15', '11:00:00', 6, 'Free', 0.00, '../assets/media/event/event-background-image/food.jpg'),
        ('Business Summit', 'Meet industry leaders.', 'Dubai', '2026-01-20', '09:30:00', 7, 'Paid', 500.00, '../assets/media/event/event-background-image/BusinessSummit.jpg'),
        ('Charity Run', 'Join a marathon for charity.', 'Sydney', '2026-02-10', '06:00:00', 2, 'Free', 0.00, '../assets/media/event/event-background-image/CharityRun.jpg')";

    if ($conn->query($insert_sql) === TRUE) {
       // echo "✅ Sample events inserted into 'events' table!<br>";
    } else {
        echo "❌ Error inserting data: " . $conn->error;
    }
} else {
   // echo "ℹ️ Data already exists in 'events' table. No new data inserted.<br>";
}

$tableSql = "CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    namec VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    room INT NOT NULL,
    email VARCHAR(100) NOT NULL,
    participants INT NOT NULL,
    title VARCHAR(255) NOT NULL
)";


// Check if the table is created successfully
if ($conn->query($tableSql) === TRUE) {
  //  echo "Table 'registrations' created successfully!";
} else {
    echo "Error creating table: " . $conn->error;
}

// Execute the query to create the table
if ($conn->query($tableSql) === TRUE) {
  //  echo "Table 'registrations' created successfully.\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}



?>





<?php include('../includes/config.php'); ?>

<?php include('../includes/header.php'); ?>

<link rel="stylesheet" href="../assets/css/event.css">

    <div class="header-container">
        <div class="section__container" id="home">
            <div class="container-text">
                <h1>Event</h1>
                <div class="page-path">
                    <p><span>Home ></span> Event</p>
                </div>
            </div>
        </div>
    </div>

    <div class="sec">
        <div class="radio-inputs">
            <label class="radio">
                <input type="radio" name="filter" value="Free" onclick="setFilter('Free')" />
                <span class="name">FREE</span>
            </label>
            <label class="radio">
                <input type="radio" name="filter" value="Paid" onclick="setFilter('Paid')" />
                <span class="name">PAID</span>
            </label>
            <label class="radio">
                <input type="radio" name="filter" value="All" onclick="setFilter('All')" checked />
                <span class="name">SHOW ALL</span>
            </label>
        </div>

        <div class="poster">
            
            <?php
            $sql = "SELECT * FROM events";
            $result = $conn->query($sql);
          

            if ($result->num_rows > 0) {    
                while ($row = $result->fetch_assoc()) {
                   
                    $image_path = $row["image_path"];
                    $title = $row["title"];
                    $description = $row["description"];
                    $location = $row["location"];
                    $event_date = $row["event_date"];
                    $start_time = $row["start_time"];
                    $duration = $row["duration"];
                    $event_type = $row["event_type"];
                    $price = $row["price"];

                    $eventClass = ($price == 0 || strtolower($price) == "free") ? "free" : "paid";

                    echo '<div class="event-item ' . $eventClass . '" data-type="' . $eventClass . '" style="background-image: url(\'' . htmlspecialchars($image_path, ENT_QUOTES) . '\'); margin-bottom: 20px; margin-right: 20px; margin-left: 20px;">';
                    echo '<div class="event-buttons">';
                    echo '<button class="boton-elegante" onclick="showEventDetails(
                        \''.htmlspecialchars($title, ENT_QUOTES).'\',
                        \''.htmlspecialchars($description, ENT_QUOTES).'\',
                        \''.htmlspecialchars($location, ENT_QUOTES).'\',
                        \''.htmlspecialchars($event_date, ENT_QUOTES).'\',
                        \''.htmlspecialchars($start_time, ENT_QUOTES).'\',
                        \''.htmlspecialchars($duration, ENT_QUOTES).'\',
                        \''.htmlspecialchars($event_type, ENT_QUOTES).'\',
                        \''.htmlspecialchars($price, ENT_QUOTES).'\' )">Explore</button>';
                echo '<button class="button" onclick="showRegisterForm(\'' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '\')">';

                    echo '<span>Register</span>';
                    echo '<svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
                    echo '<path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
                    echo '</svg>';
                    echo '</button>';
                    echo '</div>';
                    echo '</div>';
                     
                }
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Sanitize and fetch form data
                $fullName = trim($_POST['fullName']);
                $phone = trim($_POST['phone']);
                $room = trim($_POST['room']);
                $email = trim($_POST['email']);
                $participants = trim($_POST['participants']);
                $title = trim($_POST['title']);
                
                // Fetch complete event details based on the title
                $event_query = "SELECT * FROM events WHERE title = ?";
                $stmt_event = $conn->prepare($event_query);
                
                if ($stmt_event === false) {
                    die("Error preparing the event query: " . $conn->error);
                }
                
                $stmt_event->bind_param("s", $title);
                $stmt_event->execute();
                $event_result = $stmt_event->get_result();
                
                // Initialize variables for event details
                $event_id = null;
                $description = "";
                $location = "";
                $event_date = "";
                $start_time = "";
                $duration = "";
                $event_type = "";
                $price = 0;
                $image_path = "";
                
                // If event is found, get all details
                if ($event_result->num_rows > 0) {
                    $event_data = $event_result->fetch_assoc();
                    $event_id = $event_data['id'];
                    $description = $event_data['description'];
                    $location = $event_data['location'];
                    $event_date = $event_data['event_date'];
                    $start_time = $event_data['start_time'];
                    $duration = $event_data['duration'];
                    $event_type = $event_data['event_type'];
                    $price = $event_data['price'];
                    $image_path = $event_data['image_path'];
                } else {
                    // Handle case where event is not found
                    echo "<script>alert('Event with title \"$title\" not found. Please try again.');</script>";
                    exit();
                }
                
                require 'PHPMailer/src/Exception.php';
                require 'PHPMailer/src/PHPMailer.php';
                require 'PHPMailer/src/SMTP.php';
                
                // Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);
                
                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host       = MAILE_HOST;
                    $mail->SMTPAuth   = MAILE_SMTPAUTH;
                    $mail->Username   = MAILE_UERNAME ;
                    $mail->Password   = MAILE_PASSWORD;
                    $mail->SMTPSecure = MAILE_SMTPSECURE;
                    $mail->Port       = MAILE_PORT;
                    
                    // Format date and time for better readability
                    $formatted_date = date('l, F j, Y', strtotime($event_date));
                    $formatted_time = date('g:i A', strtotime($start_time));
                    $end_time = date('g:i A', strtotime($start_time . " + $duration hours"));
                    
                    // Create beautiful HTML email
                    $mail->isHTML(true);
                    $mail->Subject = "Your Registration: $title at Secret Berry Resort";
                    
                    // Beautiful HTML Email Template
                    $mail->Body = "
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
                            .header { background-color: #fd557f; color: white; padding: 20px; text-align: center; }
                            .content { padding: 20px; background-color: #fafafa; }
                            .event-details, .registration-details { background-color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                            h1, h2 { color: #5c2d91; margin-top: 0; }
                            .footer { background-color: #333; color: white; text-align: center; padding: 15px; font-size: 12px; }
                            .button { background-color: #5c2d91; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 15px; }
                            table { width: 100%; border-collapse: collapse; }
                            td { padding: 8px; border-bottom: 1px solid #eee; }
                            td:first-child { font-weight: bold; width: 140px; }
                            .price { color: #e74c3c; font-weight: bold; }
                            .free { color: #27ae60; font-weight: bold; }
                            .banner { width: 100%; max-height: 200px; object-fit: cover; }
                            .thank-you { text-align: center; font-size: 18px; margin: 20px 0; }
                            .location-highlight { background-color: #f5f5f5; padding: 10px; border-left: 4px solid #5c2d91; margin: 10px 0; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h1>Registration Confirmation</h1>
                            </div>
                            
                            <div class='content'>
                                <p>Dear <b>$fullName</b>,</p>
                                <p class='thank-you'>Thank you for registering for our event!</p>
                                
                                <div class='event-details'>
                                    <h2>🎉 Event Details</h2>
                                    <table>
                                        <tr>
                                            <td>Event:</td>
                                            <td><b>$title</b></td>
                                        </tr>
                                        <tr>
                                            <td>Description:</td>
                                            <td>$description</td>
                                        </tr>
                                        <tr>
                                            <td>Date:</td>
                                            <td><b>$formatted_date</b></td>
                                        </tr>
                                        <tr>
                                            <td>Time:</td>
                                            <td><b>$formatted_time - $end_time</b> ($duration hours)</td>
                                        </tr>
                                        <tr>
                                            <td>Price:</td>
                                            <td>" . ($price > 0 ? "<span class='price'>$".$price."</span> <span style='font-weight: bold; color: #FF5733;'> : for one person</span>" : "<span class='free'>Free</span>") . "</td>

                                        </tr>
                                    </table>
                                    
                                    <div class='location-highlight'>
                                        <h3>📍 Location</h3>
                                        <p><b>$location</b></p>
                                    </div>
                                </div>
                                
                                <div class='registration-details'>
                                    <h2>👤 Your Registration Information</h2>
                                    <table>
                                        <tr>
                                            <td>Name:</td>
                                            <td>$fullName</td>
                                        </tr>
                                        <tr>
                                            <td>Phone:</td>
                                            <td>$phone</td>
                                        </tr>
                                        <tr>
                                            <td>Room:</td>
                                            <td>$room</td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td>$email</td>
                                        </tr>
                                        <tr>
                                            <td>Participants:</td>
                                            <td>$participants</td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <p>We're excited to have you join us! If you have any questions or need to make changes to your registration, please contact our support team.</p>
                                
                                <p style='text-align: center;'>
                                    <a href='#' class='button'>Add to Calendar</a>
                                </p>
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
                    $mail->AltBody = "REGISTRATION CONFIRMATION\n\n" .
                                    "Dear $fullName,\n\n" .
                                    "Thank you for registering for our event!\n\n" .
                                    "EVENT DETAILS:\n" .
                                    "Event: $title\n" .
                                    "Description: $description\n" .
                                    "Date: $formatted_date\n" .
                                    "Time: $formatted_time - $end_time ($duration hours)\n" .
                                    "Location: $location\n" .
                                    "Price: " . ($price > 0 ? '$'.$price : 'Free') . "\n\n" .
                                    "YOUR REGISTRATION INFORMATION:\n" .
                                    "Name: $fullName\n" .
                                    "Phone: $phone\n" .
                                    "Room: $room\n" .
                                    "Email: $email\n" .
                                    "Participants: $participants\n\n" .
                                    "We're excited to have you join us! If you have any questions or need to make changes to your registration, please contact our support team.\n\n" .
                                    "© " . date('Y') . " Secret Berry Resort. All rights reserved.\n";
                    
                    // Clear any existing recipients and add the user's email
                    $mail->clearAddresses();
                    $mail->addAddress($email);  // Send to user email
                    
                    if ($mail->send()) {
                        // Now send a notification to admin
                        $mail->clearAddresses();
                        $mail->addAddress('joe@example.net');  // Admin email
                        $mail->Subject = "New Event Registration: $title";
                        
                        // Simpler email for admin
                        $mail->Body = "
                        <h2>New Event Registration</h2>
                        <p><strong>Event:</strong> $title</p>
                        <p><strong>Date:</strong> $formatted_date</p>
                        <p><strong>Participant:</strong> $fullName</p>
                        <p><strong>Room:</strong> $room</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Phone:</strong> $phone</p>
                        <p><strong>Number of Participants:</strong> $participants</p>
                        ";
                        
                        $mail->send();
                        
                        // Save registration data into the database with event_id and all details
                        $stmt = $conn->prepare("INSERT INTO event_reg (namec, phone, room, email, participants, title) 
                      VALUES (?, ?, ?, ?, ?, ?)");

                        if ($stmt === false) {
                            die("Error preparing the statement: " . $conn->error);
                        }

                        // Bind parameters to the SQL query (s = string, i = integer)
            $stmt->bind_param("ssssis", $fullName, $phone, $room, $email, $participants, $title);
                        
                        // Execute the query and check for errors
                        if ($stmt->execute()) {
                            echo "<script>
                                alert('Registration successful! A confirmation email has been sent to your email address.');
                                window.location.href = 'event.php';
                            </script>";
                        } else {
                            echo "<script>alert('Database Error: " . $stmt->error . "');</script>";
                        }
                    } else {
                        echo "<script>alert('Email could not be sent. Please try again.');</script>";
                    }
                } catch (Exception $e) {
                    echo "<script>alert('Message could not be sent. Mailer Error: " . $mail->ErrorInfo . "');</script>";
                }
            }
            ?>
        </div>
    </div>
    <div id="customModal" class="modal">
    <div class="modal-content">
        <button class="close-btn" onclick="closeModal()">✖</button>
        <div class="modal-title" id="modalTitle"></div>
        <div class="modal-body" id="modalBody"></div>
    </div>
</div>

<script src="../assets/js/event.js"></script>


<?php include('../includes/footer.php'); ?>
