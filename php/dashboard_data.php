<?php
require_once 'db_connection.php'; // Ensure proper database connection

// Example: Fetch total number of users
$sql = "SELECT COUNT(id) AS total_users FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalUsers = $row['total_users'];
} else {
    $totalUsers = 0;
}

// Example: Fetch other metrics as needed

// Prepare data to send back as JSON
$data = array(
    'total_users' => $totalUsers,
    // Add more metrics here
);

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
