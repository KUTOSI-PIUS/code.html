<?php
include("db_connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Ensure user is logged in
    $category = $_POST['category'];
    $limit = $_POST['limit'];

    // Validate inputs
    if (empty($category) || empty($limit)) {
        echo "All fields are required!";
        exit;
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO budgets (user_id, category, limit_amount) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $category, $limit); // "i" = integer, "s" = string
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Budget set successfully.";
    } else {
        echo "Error setting budget: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>