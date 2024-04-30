<?php
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>';

require_once '../classes/db_classes.php'; 

session_start();

function get_all_data()
{
    $database = Database::getInstance();
    $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    return $users = $database->select("users");
}

function display_table($rows){
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Users List</title>
    </head>
    <body>
    <div class="container mt-5">
';
    if (empty($rows)) {
        echo '
        <div class="m-auto d-flex align-items-baseline text-center" style="width:fit-content;">
            <h2 class="text-center mx-2">Product List is empty.</h2>
            <div class="rounded-circle p-2" style="width: fit-content; background-color: #BA6644;">
            <a href="add_user_page.php">
                <i class="fa-solid fa-plus" style="color:white;font-size: 23px;"></i>
            </a>
        </div>
        </div>';
    } else {
        echo "<h2 class='text-center'>Users List</h2>
        <div class='table-responsive' style='position:relative; '>
        <div class='rounded-circle p-2 ' style =' position:absolute;right: 0px;  width: fit-content; background-color: #BA6644;'>
                <a href='add_user_page.php'>
                    <i class='fa-solid fa-plus' style='color:white;font-size: 20px;'></i>
                </a>
            </div>  
        <table class='table table-striped mt-2'> <tr> <th>ID</th>  <th>Name</th>  <th>Email</th>
        <th>Role</th> <th>room_no</th> <th>Actions</th> 
        </tr>";
    
        foreach ($rows as $row) {
            $url_query_string = $row['id'];
            $delete_url = "../handlers/delete_user_handler.php?id={$url_query_string}";
            $edit_url = "../pages/update_user_page.php?id={$url_query_string}";
    
            echo "<tr>";
            foreach ($row as $key => $value) {
                // Exclude the 'password' and 'image' fields
                if ($key !== 'password' && $key !== 'image') {
                    echo "<td>{$value}</td>";
                }
            }
            echo "<td><a href='{$edit_url}' ><i class='fa-solid fa-pen-to-square' style = 'font-size: 20px;color: #1A4D2E;'>
            </i></a>
            |
            <a href='{$delete_url}' ><i class='fa-solid fa-trash-can'  style = 'font-size: 20px;color: #8B322C;' ></i></a>
            </td>";
            echo "</tr>";
        }
        echo "</table>
        </div>
        </div>
        </body>
        </html>";
    }
    
    
}

$rows = get_all_data();

require '../inc/admin_navbar.php';

display_table($rows);
?>
