<?php

require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_GET['id'];


    $database = Database::getInstance();

    $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


    $result = $database->delete("users",$user_id );

    if ($result) {
        header("Location: ../pages/users_table.php");
        echo "user deleted successfully.";
    } else {
        echo "Error deleting user.";
    }
}
?>