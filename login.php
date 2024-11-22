<?php
// Include the database connection file
include 'db_connect.php';

// Start a session
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and trim input values
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Input validation
    if (empty($email) || empty($password)) {
        echo "Both email and password are required.";
        exit;  // Stop further script execution
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;  // Stop further script execution
    }

    // Prepare SQL statement to check if the email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with this email exists
    if ($result->num_rows == 0) {
        echo "No user found with this email.";
        exit;  // Stop further script execution
    }

    // Fetch user data
    $user = $result->fetch_assoc();

    // Verify the password using password_verify
    if (password_verify($password, $user['password'])) {
        // Password is correct, set session variables
        $_SESSION['user_id'] = $user['id']; // Store the user ID in the session

        // Redirect to the dashboard
        header("Location: dashboard.php");
        exit(); // Ensure no further code is executed
    } else {
        echo "Incorrect password.";
        exit;  // Stop further script execution
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>