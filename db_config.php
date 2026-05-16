<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password is empty
$dbname = "lifelink_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Note: If the connection is successful, this page will remain blank. 
// That is exactly what we want because we will "include" this file in other pages.
?>