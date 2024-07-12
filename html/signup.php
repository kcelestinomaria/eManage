<?php
include './php/db_connection.php';

// Sanitize input data
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into users table
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "User registered successfully";
    // Redirect to a success page or home page
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Gourmet Delights</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Include Header -->
    <?php include '../includes/header.html'; ?>

    <div class="container">
        <main>
            <h1>Sign Up</h1>
            <form action="signup.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <input type="submit" value="Sign Up">
            </form>
        </main>
    </div>

    <!-- Include Footer -->
    <?php include '../includes/footer.html'; ?>
</body>
</html>
