<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost:8080";
$username = "";
$password = "";
$dbname = "gourmet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total users
$sql = "SELECT COUNT(*) as total_users FROM users";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo json_encode($data);

$conn->close();
?>
