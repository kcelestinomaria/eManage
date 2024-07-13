<?php
// delete_inventory.php
require_once 'db_connection.php';

$id = $_GET['id'];

// Prepare SQL statement
$stmt = $pdo->prepare("DELETE FROM inventories WHERE id = ?");
$stmt->execute([$id]);

// Redirect after deleting
header('Location: inventories.php');
exit;
?>
