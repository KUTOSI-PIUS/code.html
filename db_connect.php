<?php
// Database configuration
$servername = "localhost"; // Database server
$username = "root";        // Database username
$password = "";            // Database password (leave empty if none)
$dbname = "finance";       // Updated database name
$port = 3307;              // Database port (default is 3306)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set the character set to UTF-8
$conn->set_charset("utf8");

// Connection successful
// You can now use $conn to perform database operations
?>