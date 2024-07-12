<?php require_once '../includes/header.html'; ?>

<?php
// Include database connection
require_once '../php/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item = $_POST["item"];
    $quantity = $_POST["quantity"];
    $details = $_POST["details"];

    // Sanitize input to prevent SQL injection
    $item = htmlspecialchars($item);
    $quantity = intval($quantity); // Ensure quantity is an integer
    $details = htmlspecialchars($details);

    try {
        // Insert order into database
        $stmt = $conn->prepare("INSERT INTO orders (item, quantity, details) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $item, $quantity, $details);
        $stmt->execute();

        echo "Order placed successfully!";
        // Optionally redirect to another page after successful order placement
        // header("Location: order-confirmation.php");
        // exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    $stmt->close();
    $conn->close();
}
?>


<?php require_once '../includes/footer.html'; ?>