<?php include('../includes/config.php'); ?>

        <?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $contact = (int)$_POST['contactNo'];
    $address = $conn->real_escape_string($_POST['address']);

    if (!empty($_FILES['imgPath']['name'])) {
        $image = basename($_FILES['imgPath']['name']);
        $target = "../assets/media/service/" . $image;
        if (move_uploaded_file($_FILES['imgPath']['tmp_name'], $target)) {
            $sql = "UPDATE users SET full_name='$name', email='$email', contactNo='$contact', address='$address', imgPath='$image' WHERE userId=$userId";
        } else {
            $msg = "Image upload failed.";
        }
    } else {
        $sql = "UPDATE users SET full_name='$name', email='$email', contactNo='$contact', address='$address' WHERE userId=$userId";
    }

    if (empty($msg) && $conn->query($sql)) {
        $msg = "Profile updated successfully.";
    }
}

$result = $conn->query("SELECT * FROM users WHERE userId = $userId");
$user = $result->fetch_assoc();
$conn->close();
?>

<?php include('../includes/header.php'); ?>
<link rel="stylesheet" href="../assets/css/edit_profile.css">

    <div class="header-container">
        <div class="section__container" id="home">
            <div class="container-text">
                <h1>Edit Profile</h1>
                <div class="page-path">
                    <p><span>Home ></span> Edit Profile</p>
                </div>
            </div>
        </div>
    </div>

    <div class="sec">





<div class="edit-form">
    <h2>Edit Profile</h2>
    <?php if ($msg): ?><p class="msg"><?php echo $msg; ?></p><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label>Contact Number:</label>
        <input type="text" name="contactNo" value="<?php echo htmlspecialchars($user['contactNo']); ?>" required>

        <label>Address:</label>
        <textarea name="address" rows="3" required><?php echo htmlspecialchars($user['address']); ?></textarea>

        <label>Profile Image:</label>
        <input type="file" name="imgPath" accept="image/*">

        <button type="submit" class = "upBTn">Update</button>
    </form>
    <a href="proflie.php" class="back">← Back to Profile</a>
</div>




            
    </div>

<script src="../assets/js/ADD YOUR JS NAME"></script>

<?php include('../includes/footer.php'); ?>
