<?php require_once '../includes/header.html'; ?>

<?php
// Include database connection
require_once '../php/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $date = $_POST["date"];

    // Sanitize input to prevent SQL injection
    $name = htmlspecialchars($name);
    $email = htmlspecialchars($email);
    $date = htmlspecialchars($date);

    try {
        // Insert reservation into database
        $stmt = $conn->prepare("INSERT INTO reservations (name, email, date) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $date);
        $stmt->execute();

        echo "Reservation submitted successfully!";
        // Optionally redirect to another page after successful reservation
        // header("Location: thank-you.php");
        // exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    $stmt->close();
    $conn->close();
}
?>

<?php require_once '../includes/footer.html'; ?>