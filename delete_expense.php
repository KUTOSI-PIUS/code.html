<?php
include("db_connect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: expenses.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>