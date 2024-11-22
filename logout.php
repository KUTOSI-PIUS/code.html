<?php
session_start(); // Start the session

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Set a success message
$message = 'You have been logged out successfully.';
echo "<script>alert('$message'); window.location.href = 'login.html';</script>";
exit();
?>