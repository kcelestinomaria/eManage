<?php
require_once 'vendor/autoload.php'; // Path to autoload.php of Composer dependencies
require_once 'php/db_connection.php'; // Your database connection script
use RobThree\Auth\TwoFactorAuth;

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch user details from database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if user already has a 2FA secret
        $secret = $user['secret'];

        if (!$secret) {
            // Generate a new 2FA secret
            $tfa = new TwoFactorAuth('GourmetDelights');
            $secret = $tfa->createSecret();

            // Save the secret in the database for this user
            $update_sql = "UPDATE users SET secret = '$secret' WHERE id = {$user['id']}";
            if ($conn->query($update_sql) === TRUE) {
                // Generate the QR code URL
                $qrCodeUrl = $tfa->getQRCodeImageAsDataUri($email, $secret);

                // Display the QR code to the user
                echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Setup Two-Factor Authentication</title>
                    <link rel='stylesheet' href='css/style.css'>
                </head>
                <body>
                    <?php include 'includes/header.html'; ?>
                    <div class='container'>
                        <h1>Setup Two-Factor Authentication</h1>
                        <p>Scan this QR code with your 2FA app:</p>
                        <img src='$qrCodeUrl' alt='QR Code'>
                        <p>Alternatively, you can use this secret key: <code>$secret</code></p>
                        <p>After scanning or entering the secret key, enter the 6-digit code from your 2FA app below:</p>
                        <form action='signin.php' method='post'>
                            <label for='token'>Enter 2FA Token:</label>
                            <input type='text' id='token' name='token' required>
                            <input type='hidden' name='email' value='$email'>
                            <input type='hidden' name='password' value='" . htmlspecialchars($password) . "'>
                            <br>
                            <input type='submit' value='Verify'>
                        </form>
                    </div>
                    <?php include 'includes/footer.html'; ?>
                </body>
                </html>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            // User already has a 2FA secret
            echo "2FA is already set up for this account.";
        }
    } else {
        // No user found with this email
        echo "No user found with this email.";
    }
} else {
    // Redirect if accessed without proper POST data
    header("Location: index.html");
    exit();
}

$conn->close();
?>
