<?php

require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST['category_name'];

    $database = Database::getInstance();

    $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $table = "categories";
    $columns = "name";
    $values = "'$category_name'";

    $result = $database->insert($table, $columns, $values);

    if ($result) {
        header("Location: ../pages/categories_table.php");
        echo "Category inserted successfully.";
    } else {
        echo "Error inserting category.";
    }
}
?>
