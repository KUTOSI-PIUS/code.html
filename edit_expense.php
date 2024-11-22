<?php
include("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE expenses SET category = ?, amount = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sdsi", $category, $amount, $description, $id);

    if ($stmt->execute()) {
        header("Location: expenses.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $expense = $result->fetch_assoc();
} else {
    die("Invalid Request.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Expense</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Expense</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $expense['id']; ?>">
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" name="category" value="<?php echo $expense['category']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" name="amount" value="<?php echo $expense['amount']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" required><?php echo $expense['description']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Expense</button>
        </form>
    </div>
</body>
</html>