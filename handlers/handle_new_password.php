<?php
session_start();
require_once '../classes/db_classes.php';

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_SESSION['reset_token'];
    $new_password = $_POST['password'];

    // Check if token and new password are provided
    if (empty($token) || empty($new_password)) {
        echo "Error: Token or new password is missing.";
        exit;
    }

    // Check if token exists and is valid
    $token_info = $database->searchResetToken($token);

    if ($token_info) {
        // Token exists and is valid, proceed with password reset
        $email = $token_info['email'];

        // Update the password in the database  
        $password_updated = $database->updatePassword($email, $new_password);

        if ($password_updated) {
            // Password updated successfully
            echo "Password updated successfully";
            header('Location: ../pages/login.php');
            exit;
        } else {
            // Password update failed
            echo "Error: Password reset failed. Please try again later.";
        }
    } else {
        // Token does not exist or is invalid
        echo "Error: Invalid or expired token. Please request a new password reset.";
    }
}
?>
