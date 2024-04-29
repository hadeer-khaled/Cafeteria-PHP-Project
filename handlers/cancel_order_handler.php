<?php

require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $order_id = $_GET['id'];

    $database = Database::getInstance();
    $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $table = "orders";
    $result = $database->delete($table,$order_id );

    if ($result) {
        header("Location: ../pages/myOrders.php");
    } else {
        echo "Error deleting Product.";
    }
}
?>
