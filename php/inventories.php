<?php
// inventories.php
require_once 'config.php';

// Fetch all inventory items
$stmt = $pdo->query("SELECT * FROM inventories");
$inventories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Inventories</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Inventory Items</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php foreach ($inventories as $inventory): ?>
                <tr>
                    <td><?php echo $inventory['name']; ?></td>
                    <td><?php echo $inventory['description']; ?></td>
                    <td><?php echo $inventory['quantity']; ?></td>
                    <td><?php echo $inventory['price']; ?></td>
                    <td>
                        <a href="edit_inventory.php?id=<?php echo $inventory['id']; ?>">Edit</a>
                        <a href="delete_inventory.php?id=<?php echo $inventory['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <a href="add_inventory.php">Add New Inventory Item</a>
    </div>
</body>
</html>
