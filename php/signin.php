<?php
require_once 'vendor/autoload.php'; // Path to autoload.php of Composer dependencies
require_once 'php/db_connection.php'; // Your database connection script
use RobThree\Auth\TwoFactorAuth;

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch user details from database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            
            // Password is correct
            if (!empty($user['secret'])) {
                // User has 2FA set up, initiate 2FA verification
                $tfa = new TwoFactorAuth('GourmetDelights');

                // Verify if 2FA token is submitted
                if (isset($_POST['token'])) {
                    $token = $_POST['token'];
                    $valid = $tfa->verifyCode($user['secret'], $token);

                    if ($valid) {
                        // 2FA token is valid, set session variables
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        
                        // Redirect to homepage or dashboard
                        header("Location: index.html");
                        exit();
                    } else {
                        // Invalid 2FA token
                        echo "Invalid 2FA token. Please try again.";
                    }
                } else {
                    // Display the 2FA form
                    ?>
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Two-Factor Authentication</title>
                        <link rel="stylesheet" href="css/style.css">
                    </head>
                    <body>
                        <?php include 'includes/header.html'; ?>
                        <div class="container">
                            <h1>Two-Factor Authentication</h1>
                            <form action="signin.php" method="post">
                                <label for="token">Enter 2FA Token:</label>
                                <input type="text" id="token" name="token" required>
                                <br>
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                                <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
                                <input type="submit" value="Verify">
                            </form>
                        </div>
                        <?php include 'includes/footer.html'; ?>
                    </body>
                    </html>
                    <?php
                }
            } else {
                // User does not have 2FA set up, redirect to set it up
                header("Location: setup2fa.php?email=" . urlencode($email));
                exit();
            }
            
        } else {
            // Incorrect password
            echo "Incorrect password.";
        }
    } else {
        // No user found with this email
        echo "No user found with this email.";
    }

    $conn->close();
}
?>
