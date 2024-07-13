<?php
// create_inventory.php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO inventories (name, description, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $quantity, $price]);

    // Redirect after adding
    header('Location: inventories.php');
    exit;
}
?>
