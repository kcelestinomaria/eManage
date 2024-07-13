<?php
require_once '../php/db_connection.php'; // Ensure this includes your database connection

// Check if user is authenticated as admin (you should have a mechanism to check admin status)
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: signin.php"); // Redirect to sign-in if not authenticated as admin
    exit();
}

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Gourmet Delights</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Include Header -->
    <?php include '../includes/header.html'; ?>

    <div class="container">
        <main>
            <h1>User Management</h1>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td><a href='edit_user.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_user.php?id=" . $row['id'] . "'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </main>
    </div>

    <!-- Include Footer -->
    <?php include '../includes/footer.html'; ?>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
