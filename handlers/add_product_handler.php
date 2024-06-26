<?php
require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

var_dump($_POST);
var_dump($_FILES);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = Database::getInstance();
    $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $categories = $database->select("categories");

    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_stock = $_POST['stock'];
    $product_image_name = $_FILES['image']['name'];
    $product_image_tmp = $_FILES['image']['tmp_name']; 
    $category_id = $_POST['category_id'];

    $upload_directory = '../assets/images/'; 
    $product_image_path = $upload_directory . $product_image_name; 

    if (move_uploaded_file($product_image_tmp, $product_image_path)) {
        $table = "products";
        $columns = "`name`, `price`, `stock`, `image`, `category_id`";
        $values = "'$product_name', '$product_price','$product_stock', '$product_image_name', '$category_id'";

        $result = $database->insert($table, $columns, $values);

        if ($result) {
           
            header("Location: ../pages/products_table.php");
            echo "Product inserted successfully.";
        } else {
            echo "Error inserting product.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
