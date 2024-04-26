<?php

require_once '../classes/db_classes.php';

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$users = $database->select("users");


$errors = [];
$old_data = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $errors["email"] = "Email is required";
    } else {
        $email = $_POST["email"];
        $pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        preg_match_all($pattern, $email, $matches);
        if (strlen($matches[0][0]) !== strlen($email)) {
            $errors["email"] = "Invalid email format";
        } else {
            $old_data['email'] = $email;
        }
    }

    if (empty($_POST["password"])) {
        $errors['password'] = "Password is required";
    } else {
        $old_data['password'] = $_POST["password"];
    }

    // Check if there are any errors
    if (count($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $old_data;
        header("Location: login.php");
        exit;
    }

    // Perform login validation
    $email = $_POST['email'];
    $password = $_POST['password'];

    $valid_login = false;
    if(!empty($users)){
        foreach ($users as $user) {
            $user_info = $user;
            if ($user_info['email'] == $email && $user_info['password'] == $password) {
                $valid_login = true;
                break;
            }
        }
    }
        
    if ($valid_login) {
        $_SESSION['email'] = $email;
        header('Location: ../pages/products_table.php');
        exit;
    } else {
        $errors['login'] = 'Invalid email or password.';
        $_SESSION['errors'] = $errors;
        header("Location: ../pages/login.php");
        exit;
    }
}
?>
