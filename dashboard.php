<?php
session_start();
include("db_connect.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

// Retrieve the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch total expenses for the user
$total_expenses_query = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE user_id = ?";
$stmt = $conn->prepare($total_expenses_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_expenses = $result->fetch_assoc()['total_expenses'] ?? 0;

// Fetch total budget for the user
$total_budget_query = "SELECT SUM(limit_amount) AS total_budget FROM budgets WHERE user_id = ?";
$stmt = $conn->prepare($total_budget_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_budget = $result->fetch_assoc()['total_budget'] ?? 0;

// Calculate remaining budget
$remaining_budget = $total_budget - $total_expenses;

// Close the prepared statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <h2>Welcome to Your Dashboard</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>Total Expenses:</strong> $<?php echo number_format($total_expenses, 2); ?></p>
                <p><strong>Total Budget:</strong> $<?php echo number_format($total_budget, 2); ?></p>
                <p><strong>Remaining Budget:</strong> $<?php echo number_format($remaining_budget, 2); ?></p>
                <a href="expenses.html" class="btn btn-primary">Manage Expenses</a>
                <a href="budget.html" class="btn btn-secondary">Set Budgets</a>
            </div>
        </div>
    </div>
</body>
</html>