<?php
// Start the session
session_start();

// Database connection parameters
$host = 'localhost'; // Change as needed
$db = 'your_database'; // Change to your database name
$user = 'your_username'; // Change to your database username
$pass = 'your_password'; // Change to your database password

// Create a connection to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT category, SUM(amount) AS total FROM expenses WHERE user_id = ? GROUP BY category");
$stmt->bind_param("i", $_SESSION['user_id']); // Assuming user_id is stored in session

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Initialize arrays to hold expense data
$expenses = [];

// Fetch the data
while ($row = $result->fetch_assoc()) {
    $expenses[] = [
        'category' => $row['category'],
        'total' => (float)$row['total']
    ];
}

// Prepare the budget data
$budget_stmt = $conn->prepare("SELECT category, limit_amount FROM budgets WHERE user_id = ?");
$budget_stmt->bind_param("i", $_SESSION['user_id']);
$budget_stmt->execute();
$budget_result = $budget_stmt->get_result();

$budgets = [];
while ($row = $budget_result->fetch_assoc()) {
    $budgets[] = [
        'category' => $row['category'],
        'limit_amount' => (float)$row['limit_amount']
    ];
}

// Close the statements and connection
$stmt->close();
$budget_stmt->close();
$conn->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode(['expenses' => $expenses, 'budgets' => $budgets]);
?>