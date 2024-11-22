<?php
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    // Validate inputs
    if (empty($category) || empty($amount) || empty($description)) {
        echo "All fields are required!";
        exit;
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO expenses (category, amount, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $category, $amount, $description);  // "s" = string, "i" = integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Expense added successfully.";
    } else {
        echo "Error adding expense: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
