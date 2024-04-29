<?php


// Include PHPMailer files from the src folder
require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';
require '../env.php';
require_once '../classes/db_classes.php';


$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the email address
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    // Check if the user exists in the database
    $user = $database->selectUserByEmail($email);

    if ($user) {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Add the reset token to the database
        $database->addResetToken($email, $token);

        // Initialize PHPMailer and send the password reset email
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = gmail; // Your Gmail email address
            $mail->Password = gmail_password; // Your Gmail password
            $mail->SMTPSecure = 'TLS';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('abanoub.am67@gmail.com', 'Abanoub');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Password Reset';
            $mail->Body = 'Click the following link to reset your password: <a href="http://localhost:8080/OSAD%20php/Project%20PHP/Cafeteria-PHP-Project/handlers/handle_reset_password.php?token=' . $token . '">Reset Password</a>';
            $mail->send();

            echo '<div style="background-color: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6; border-radius: 4px; padding: 10px;">';
            echo 'Password reset link has been sent to your email address.';
            echo '</div>';
        } catch (Exception $e) {
            echo 'Error sending email: ', $mail->ErrorInfo;
        }
    } else {
        // User not found in the database
        echo '<div style="background-color: #dff0d8; color: red; border: 1px solid #d6e9c6; border-radius: 4px; padding: 10px;">';
        echo 'Email not found.';
        echo '</div>';
    }
}
?>