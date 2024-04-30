<?php

require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $roomNo = $_POST['room_id'];
    
    $errors = [];
$old_data= [];
if (empty($_POST["name"])){
    $errors["name"] = "name is required";
}else{
    $old_data['name'] = $_POST["name"];
}
if (empty($_POST["email"])){
    $errors["email"] = "email is required";
}else{
    $email=$_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    else{
        $old_data['email'] = $_POST["email"];
    }
}

if (empty($_POST["room_id"])){
    $errors["room_id"] = "roomNo is required";
}else{
    $old_data['room_id'] = $_POST["room_id"];
}
if (empty($_POST["password"])){
    $errors['password'] = "Password is required";
}else{

    if (empty($_POST["confirmPassword"])){
        $errors['confirmPassword'] = "confirmPassword is required";
    }else{
        if($_POST['password'] !==$_POST['confirmPassword']){
        $errors['confirmPassword'] = "Passwords do not match";

        }
        $old_data['confirmPassword'] = $_POST["confirmPassword"];
    }

    $old_data['password'] = $_POST["password"];
}

    if (count($errors)){
        $errors = json_encode($errors);
        $old_data = json_encode($old_data);
        if (! empty($old_data)){
            $url= "errors={$errors}&old_data={$old_data}";
        }else{
            $url= "errors={$errors}";
        }
        header("Location:../pages/add_user_page.php?{$url}");
    }else{
        $database = Database::getInstance();

        $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        $table = "users";
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if (isset($_FILES['image']['tmp_name'])){
            $filename = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
        
            $newFilename = $_POST["email"] . ".$extension";
            $path = "../images/{$newFilename}";
            $saved = move_uploaded_file($tmp_name, $path);
        
        }
        $columns = "username, email, password,room_id, image";
        $values = "'$name', '$email', '$hashed_password ','$roomNo', '$path' "; 
        if ($database->insert($table, $columns, $values)) {
            echo "Record inserted successfully.";
             header("Location:../pages/users_table.php");
        } else {
            echo "Error inserting record.";
        }

       
    
    }

}
