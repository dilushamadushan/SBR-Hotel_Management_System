<?php
require_once 'conn.php'; 

$host = $_ENV['DB_HOST'];
$dbusername = $_ENV['DB_USERNAME'];
$dbpassword = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully";
}
?>
