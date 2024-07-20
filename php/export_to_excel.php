<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=report.xls");

$servername = "localhost:8080";
$username = "root";
$password = "";
$dbname = "gourmet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

echo "Username\tEmail\n";

while ($row = $result->fetch_assoc()) {
    echo $row['username'] . "\t" . $row['email'] . "\n";
}

$conn->close();
?>
