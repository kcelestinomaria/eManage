<?php
require_once '../php/db_connection.php'; // Ensure this includes your database connection

// Check if user is authenticated as admin (you should have a mechanism to check admin status)
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: signin.php"); // Redirect to sign-in if not authenticated as admin
    exit();
}

// Fetch user details based on ID from URL parameter
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Sanitize input
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "User ID not provided.";
    exit();
}

// Process form submission to update user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Update user in the database
    $update_sql = "UPDATE users SET username = '$username', email = '$email' WHERE id = $user_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "User details updated successfully.";
        // Optionally redirect to user management page
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Gourmet Delights</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Include Header -->
    <?php include '../includes/header.html'; ?>

    <div class="container">
        <main>
            <h1>Edit User</h1>
            <form action="edit_user.php?id=<?php echo $user_id; ?>" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                <br>
                <input type="submit" value="Save">
            </form>
        </main>
    </div>

    <!-- Include Footer -->
    <?php include '../includes/footer.html'; ?>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
