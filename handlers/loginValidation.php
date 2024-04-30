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
    $current_user = null;
    if(!empty($users)){
        foreach ($users as $user) {
            $user_info = $user;
            if ($user_info['email'] == $email && password_verify($password, trim($user_info['password'])) ) {
                $valid_login = true;
                $current_user = $user_info;
                break;
            }
        }
    }
        
    if ($valid_login) {
        $_SESSION['user_id'] = $current_user['id'];
        $_SESSION['username'] = $current_user['username'];
        $_SESSION['user_image'] = $current_user['image'];
        $_SESSION['user_role'] = $current_user['role'];
        function generate_user_token() {
            return md5(uniqid(mt_rand(), true));
        }
        $user_token = generate_user_token();
        setcookie('auth_token', $user_token, time() + (86400 * 30), '/');
        if( $_SESSION['user_role']  == "admin"){
            header('Location: ../pages/admin.php');
        }else{
            header('Location: ../pages/index.php');
        }
        exit();

    } else {
        $errors['login'] = 'Invalid email or password.';
        $_SESSION['errors'] = $errors;
        header("Location: ../pages/login.php");
        exit;
    }
}
?>
