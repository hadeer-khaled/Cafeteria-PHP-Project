<?php
require_once '../classes/db_classes.php'; 

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$order_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$order_id) {

    header("Location: checks.php");
    exit();
}

$order = $database->selectById("orders", $order_id);

$users_orders = [];


$order_items = $database->selectById("order_items", $order_id);


?>








<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php require '../inc/admin_navbar.php'; ?>
    <div class="container">
        <h2 class="text-center">Order Details</h2>
        <div class="card">
            <div class="card-header">
                <h3>Order Information</h3>
            </div>
            <div class="card-body">
                <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
                <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
                <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
                <p><strong>Total Amount:</strong> <?php echo $order['total_amount']; ?></p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h3>Order Items</h3>
            </div>
            <div class="card-body">
                <?php foreach ($order_items as $item): ?>
                    <div class="card mb-2">
                        <div class="card-body">
                            <p><strong>Item Name:</strong> <?php echo $item['name']; ?></p>
                            <p><strong>Price:</strong> <?php echo $item['price']; ?></p>
                            <p><strong>Quantity:</strong> <?php echo $item['quantity']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
