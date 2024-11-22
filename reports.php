<?php
include 'db_connect.php';  // Include your database connection

// Fetch data for expenses
$expense_query = "SELECT category, SUM(amount) AS total FROM expenses GROUP BY category";
$expense_result = $conn->query($expense_query);

// Prepare expense data
$expenses = [];
while ($row = $expense_result->fetch_assoc()) {
    $expenses[] = [
        'category' => $row['category'],
        'total' => $row['total']
    ];
}

// Fetch data for budgets
$budget_query = "SELECT category, limit_amount FROM budgets"; 
$budget_result = $conn->query($budget_query);

// Prepare budget data
$budgets = [];
while ($row = $budget_result->fetch_assoc()) {
    $budgets[] = [
        'category' => $row['category'],
        'limit_amount' => $row['limit_amount']
    ];
}

$response = [
    'expenses' => $expenses,
    'budgets' => $budgets
];

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>