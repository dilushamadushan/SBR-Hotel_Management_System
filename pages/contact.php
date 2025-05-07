<?php include('../includes/config.php'); ?>

<?php include ('../includes/header.php'); ?>
<link rel="stylesheet" href="../assets/css/contact.css">
<div class="header-container">
        <div class="section__container" id="home">
            <div class="container-text">
                <h1>CONTACT US</h1>
                <div class="page-path">
                    <p><span>Home </span> Contact Us</p>
                </div>
            </div>
        </div>
</div>

<div class="sec">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $conn->real_escape_string($_POST['fname']);
    $phoneNumber = $conn->real_escape_string($_POST['phone']);
    $country = $conn->real_escape_string($_POST['country']);
    $email = $conn->real_escape_string($_POST['Email']);
    $message = $conn->real_escape_string($_POST['Message']);

    $errors = [];

    if (empty($fullName)) {
        $errors[] = "Full name is required";
    }
    if (empty($phoneNumber)) {
        $errors[] = "Phone number is required";
    }
    if (empty($country)) {
        $errors[] = "Country is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($message)) {
        $errors[] = "Message is required";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO contact_messages (full_name, phone_number, country, email, message) 
                VALUES ('$fullName', '$phoneNumber', '$country', '$email', '$message')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Your message has been sent successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>";
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        echo "</div>";
    }
}

$conn->close();
?>

        <div class="contact-container">
            <div class="contact-form-wrapper">
                <div class="contact-info">
                    <h3 class="title">Secret Berry Resort</h3>
                    <div class="info">
                        <div class="information"><img src="../assets/media/contact/location.png" class="icon"><p>No 195, Near Victoria Park, Nuwara Eliya, Sri Lanka.</p></div>
                        <div class="information"><img src="../asssets/media/contact/gmail.png" class="icon"><p>secretberry@gmail.com</p></div>
                        <div class="information"><img src="../assets/media/contact/phone-call.png" class="icon"><p>+94 702384982</p></div>
                    </div>
                    <div class="social-media">
                        <p>Connect with us:</p>
                        <div class="social-icons">
                            <a href="#"><img src="../assets/media/contact/fb.png" class="fb"></a>
                            <a href="#"><img src="../assets/media/contact/twitter.png" class="twitter"></a>
                            <a href="#"><img src="../assets/media/contact/instagram.png" class="instagram"></a>
                            <a href="#"><img src="../assets/media/contact/linkedin.png" class="linkedin"></a>
                        </div>
                    </div>
                </div>
                <div class="contact-form">
                    <form action="contact.php" method="POST" class="form">
                        <h3 class="title">Contact us</h3>
                        <div class="input-container">
                            <label class="lbl1">Full Name<span style="color: red">*</span></label>
                            <label class="lbl2">Full Name..</label>
                            <input type="text" name="fname" class="input">
                        </div>
                        <div class="input-container">
                            <label class="lbl1">Phone Number<span style="color: red">*</span></label> 
                            <label class="lbl2">Phone Number</label>
                            <input type="text" name="phone" class="input">
                        </div>
                        <div class="input-container">
                            <label class="lbl1">Select your County<span style="color: red">*</span></label>
                            <label class="lbl2">Select your Country..</label>
                            <select id="country" name="country" class="input">
                                <option selected></option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Australia">Australia</option>
                                <option value="usa">USA</option>
                                <option value="canada">Canada</option>
                            </select>
                        </div>
                        <div class="input-container">
                            <label class="lbl1">Email Address<span style="color: red">*</span></label>
                            <label class="lbl2">Email Address</label>
                            <input type="email" name="Email" class="input">
                        </div>
                        <div class="input-container">
                            <label class="lbl1">Type a Message<span style="color: red">*</span></label>
                            <label class="lbl2">Type a Message..</label>
                            <textarea name="Message" class="input"></textarea>
                        </div>
                        <input type="submit" value="Send Email" class="contact-btn">
                    </form>
                </div>
            </div>
        </div>
</div>

<script src="../assets/js/contact.js"></script>

<?php include ('../includes/footer.php'); ?>