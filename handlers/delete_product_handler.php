<?php

require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $product_id = $_GET['id'];


    $database = Database::getInstance();

    $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $table = "products";

    $result = $database->delete($table,$product_id );

    if ($result) {
        header("Location: ../pages/products_table.php");
        echo "Product deleted successfully.";
    } else {
        echo "Error deleting Product.";
    }
}
?>
