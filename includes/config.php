<?php
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "sbr-db";
    
    $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }else{
       //echo "Connected successfully";
    }
?>