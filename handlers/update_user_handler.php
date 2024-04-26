<?php
require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    if (empty($_POST["username"])){
        $errors["username"] = "name is required";
    }
    if (empty($_POST["email"])){
        $errors["email"] = "email is required";
    }else{
        $email=$_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    }
    
    if (empty($_POST["room_id"])){
        $errors["room+id"] = "roomNo is required";
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
            
        }
    
        
    }

    $id = $_GET['id'];
    $updates = '';


    if (count($errors)){
        $errors = json_encode($errors);
        $old_data = json_encode($old_data);
   
            $url= "errors={$errors}&id={$id}";
        
        header("Location:../pages/update_user_page.php?{$url}");
    }else{
        foreach($_POST as $key=>$value)
        {
            if ($key !== 'id' && $key !== 'confirmPassword') {
            $updates .= $key."="."'".$value."'".",";
            }
        }
        $updates = rtrim($updates,',');
    
        $database = Database::getInstance();
        $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $result = $database->update("users", $id, $updates);

        if ($result) {
            header("Location: ../pages/users_table.php");
            echo "User updated successfully.";
        } else {
            echo "Error updating user.";
        }
}
}
?>

