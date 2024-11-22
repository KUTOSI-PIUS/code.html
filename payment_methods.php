<?php
session_start(); // Start the session
include 'db_connection.php'; // Include your database connection

// Fetch existing payment methods for the logged-in user
$user_id = $_SESSION['user_id']; // Assuming you have user session management
$sql = "SELECT * FROM payment_methods WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$payment_methods = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Manage Payment Methods</h2>
        <form action="add_payment_method.php" method="POST" class="mb-4">
            <div class="form-group">
                <label for="method">Payment Method:</label>
                <input type="text" class="form-control" id="method" name="method" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Payment Method</button>
        </form>

        <h3 class="mt-5">Existing Payment Methods</h3>
        <ul class="list-group">
            <?php foreach ($payment_methods as $method): ?>
                <li class='list-group-item'><?php echo htmlspecialchars($method['method']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>