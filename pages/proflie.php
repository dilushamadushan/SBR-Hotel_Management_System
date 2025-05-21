<?php include('../includes/config.php'); ?>


    <?php
session_start();
$_SESSION['userId'] =  $_SESSION['user_id'];

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];
$sql = "SELECT userId, email, contactNo, address, imgPath FROM users WHERE userId = $userId";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$conn->close();
?>
<?php include('../includes/header.php'); ?>
<link rel="stylesheet" href="../assets/css/profile.css">

    <div class="header-container">
        <div class="section__container" id="home">
            <div class="container-text">
                <h1>Profile</h1>
                <div class="page-path">
                    <p><span>Home ></span> Profile</p>
                </div>
            </div>
        </div>
    </div>

<div class="sec">

    


<div class="profile-card">
    <img src="../assets/media/service/<?php echo htmlspecialchars($user['imgPath']); ?>" alt="Profile Image">
    <h2><?php echo htmlspecialchars($user['userId']); ?></h2>
    <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($user['address'])); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Contact:</strong> <?php echo htmlspecialchars($user['contactNo']); ?></p>
    <a href="edit_profile.php" class="btnP">Edit Profile</a>
    <a href="../index.php" class="btnP">Logout</a>
</div>






     

    </div>

<?php include('../includes/footer.php'); ?>
