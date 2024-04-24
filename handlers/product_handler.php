<?php
require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

$database = Database::getInstance();

$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$categories = $database->select("categories");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_image = $_FILES['image']['name'];
    $category_id = $_POST['category_id'];

    $table = "products";
    $columns = "name, price, image, category_id";
    $values = "'$product_name', '$product_price', '$product_image', '$category_id'";

    $result = $database->insert($table, $columns, $values);

    if ($result) {
        echo "Product inserted successfully.";
    } else {
        echo "Error inserting product.";
    }
}
?>
