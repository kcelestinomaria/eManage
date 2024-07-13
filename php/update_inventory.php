<?php
// update_inventory.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Prepare SQL statement
    $stmt = $pdo->prepare("UPDATE inventories SET name = ?, description = ?, quantity = ?, price = ? WHERE id = ?");
    $stmt->execute([$name, $description, $quantity, $price, $id]);

    // Redirect after updating
    header('Location: inventories.php');
    exit;
}
?>
