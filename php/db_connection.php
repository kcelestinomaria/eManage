<?php require_once '../includes/header.html'; ?>

<?php
$servername = "localhost:3307"; // Replace with your MySQL server name if different
$username = "root"; // Your MySQL username (default is 'root' in XAMPP)
$password = ""; // Your MySQL password (default is empty in XAMPP)
$database = "gourmet"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


<?php require_once '../includes/footer.html'; ?>