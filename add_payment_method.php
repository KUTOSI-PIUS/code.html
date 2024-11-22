<?php
session_start(); // Start the session
include 'db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = $_POST['method'];
    $user_id = $_SESSION['user_id']; // Assuming you have user session management

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO payment_methods (user_id, method) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $method);
    
    if ($stmt->execute()) {
        // Redirect back to the payment methods page after successful insertion
        header("Location: payment_methods.php");
        exit();
    } else {
        // Handle error (optional)
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>