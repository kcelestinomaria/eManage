<?php require_once '../includes/header.html'; ?>

<?php
include '../php/db_connection.php';

session_start();

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Fetch user details from database
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Password is correct, set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        // Redirect to homepage or dashboard
        header("Location: ../index.html");
        exit();
    } else {
        // Incorrect password
        echo "Incorrect password.";
    }
} else {
    // No user found with this email
    echo "No user found with this email.";
}

$conn->close();
?>

<?php require_once '../includes/footer.html'; ?>