<?php
require_once '../vendor/autoload.php'; // Path to autoload.php of Composer dependencies
require_once 'db_connection.php'; // Your database connection script
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider; // Example QR Code provider, adjust based on your actual implementation

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_BCRYPT);

    // Create a new user in the database
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id;

        // Initialize 2FA for the user with a QR Code provider
        $qrcodeProvider = new BaconQrCodeProvider(); // Example QR code provider instance
        $tfa = new TwoFactorAuth('GourmetDelights', $qrcodeProvider);
        $secret = $tfa->createSecret();

        // Save the secret in the database for this user
        $update_sql = "UPDATE users SET secret_key = '$secret' WHERE id = $user_id";
        if ($conn->query($update_sql) === TRUE) {
            // Generate the QR code URL
            $qrCodeUrl = $tfa->getQRCodeImageAsDataUri($email, $secret);

            // Display the QR code to the user
            echo "<p>Scan this QR code with your 2FA app:</p>";
            echo "<img src='$qrCodeUrl'>";
            echo "<p>Alternatively, you can use this secret key: <strong>$secret</strong></p>";

            // Prompt user to continue to 2FA token entry
            echo "<form action='../signin.php' method='post'>
                    <label for='token'>Enter 2FA Token:</label>
                    <input type='text' id='token' name='token' required>
                    <input type='hidden' name='email' value='$email'>
                    <input type='hidden' name='password' value='" . htmlspecialchars($_POST['password']) . "'>
                    <input type='submit' value='Verify'>
                  </form>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: ../register.html");
    exit();
}
?>
