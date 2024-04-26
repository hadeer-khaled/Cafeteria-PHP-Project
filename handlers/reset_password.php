<?php


// Include PHPMailer files from the src folder
require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';
require '../env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the email address
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    
    // Generate a unique token (you can use a library like random_bytes() or uniqid() for this)
    $token = bin2hex(random_bytes(32)); 
    
    // Assuming you have a table in your database to store reset tokens, you would insert the token along with the email address and expiration timestamp
    
    // Send the password reset email
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = gmail; // Your Gmail email address
        $mail->Password = gmail_password; // Your Gmail password
        $mail->SMTPSecure = 'TLS';
        $mail->Port = 587;
    
        //Recipients
        $mail->setFrom('abanoub.am67@gmail.com', 'Abanoub'); // Your Gmail email address and name
        $mail->addAddress($email); // Add a recipient
    
        //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Password Reset';
        $mail->Body    = 'Click the following link to reset your password: <a href="http://example.com/reset_password.php?token=' . $token . '">Reset Password</a>';
    
        $mail->send();
        echo '<div style="background-color: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6; border-radius: 4px; padding: 10px;">';
        echo 'Password reset link has been sent to your email address.';
        echo '</div>';

    } catch (Exception $e) {
        echo 'Error sending email: ', $mail->ErrorInfo;
    }
}
?>
