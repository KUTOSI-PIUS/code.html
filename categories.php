<?php
// add_category.php
session_start(); // Start the session
include 'db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $user_id = $_SESSION['user_id']; // Assuming you have user session management

    $sql = "INSERT INTO categories (user_id, name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $name);
    $stmt->execute();
    $stmt->close();
    header("Location: categories.php"); // Redirect to the categories page
}
?>