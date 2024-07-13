<?php
require_once '../php/db_connection.php'; // Ensure this includes your database connection

// Check if user is authenticated as admin (you should have a mechanism to check admin status)
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: signin.php"); // Redirect to sign-in if not authenticated as admin
    exit();
}

// Process deletion based on ID from URL parameter
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Sanitize input
    $delete_sql = "DELETE FROM users WHERE id = $user_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "User deleted successfully.";
        // Optionally redirect to user management page
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "User ID not provided.";
    exit();
}
?>
