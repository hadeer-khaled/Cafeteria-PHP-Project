<?php
require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // var_dump($_POST);
    $database = Database::getInstance();
    $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $product_id = $_POST['id'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    // $product_image_name = $_FILES['image']['name'];
    // $product_image_tmp = $_FILES['image']['tmp_name']; 
    $category_id = $_POST['category_id'];

    // $upload_directory = '../assets/images/'; 
    // $product_image_path = $upload_directory . $product_image_name; 

    // if (move_uploaded_file($product_image_tmp, $product_image_path)) {
        $table = "products";
        // $values = "'$product_name', '$product_price', '$product_image_name', '$category_id'";
        $updates = '';

        foreach($_POST as $key=>$value)
        {
            $updates .= $key."="."'".$value."'".",";
        }
    
        $updates = rtrim($updates,',');
        var_dump($updates);
    

        $result = $database->update($table, $product_id, $updates);

        if ($result) {
           
            header("Location: ../pages/products_table.php");
            echo "Product updated successfully.";
        } else {
            echo "Error updating product.";
        }
}
?>