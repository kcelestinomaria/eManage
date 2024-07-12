<?php
include 'db_connection.php';

// Fetch services from products table
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>

<?php include 'includes/header.php'; ?>

<div class="container">
    <main>
        <h1>Our Services</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>$" . $row['price'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No services found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
