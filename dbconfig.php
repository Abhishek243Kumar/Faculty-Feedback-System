<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "feedback_system";

// Establish connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
