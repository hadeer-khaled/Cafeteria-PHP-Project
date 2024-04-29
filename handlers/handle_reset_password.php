
<?php
session_start();
require_once '../classes/db_classes.php';

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


$token = $_GET['token'];




$token_info = $database->searchResetToken($token);

if ($token_info) {
    $_SESSION['reset_token'] = $token;
    header('Location: ../pages/update_password.php');
} else {
    header('Location: ../pages/login.php');
}
?>
