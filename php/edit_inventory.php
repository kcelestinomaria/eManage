<?php
require_once 'db_connection.php'; // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $inventory_id = $_POST['inventory_id'];
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $quantity = intval($_POST['quantity']);

    // Prepare SQL statement to update inventory item
    $sql = "UPDATE inventories SET name=?, description=?, quantity=? WHERE id=?";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$name, $description, $quantity, $inventory_id]);
        // Redirect to inventory list or success page after update
        header('Location: inventory_list.php');
        exit();
    } catch (PDOException $e) {
        die("Error updating inventory item: " . $e->getMessage());
    }
} else {
    die("Method not allowed.");
}
?>
