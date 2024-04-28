<?php
require_once '../classes/db_classes.php'; 

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$order_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$order_id) {
    header("Location: checks.php");
}

$order = $database->selectById("orders", $order_id);
$order_items = $database->selectOrderItemsByOrderId($order_id);
$itemsWithProducts = [];
$baseImagePath = "../assets/images/";

if (!empty($order_items)) {
    foreach ($order_items as $item) {
        $product_id = $item['product_id'];
        $product = $database->selectById("products", $product_id);        
        if (!empty($product)) {
            $item['product_name'] = $product['name'];
            $item['product_price'] = $product['price'];
            $item['product_image'] = $baseImagePath . $product['image'];
            $itemsWithProducts[] = $item;
        }
    }
}

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
                <p><strong>Total Amount:</strong> <?php echo $order['total_amount'] ."<span class='badge text-bg-success'>$</span>";?></p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h3>Order Items</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itemsWithProducts as $index => $item): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><img src="<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>" style="max-width: 50px;"></td>
                                <td><?php echo $item['product_name']; ?></td>
                                <td><?php echo $item['product_price'] ."<span class='badge text-bg-success'>$</span>";?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>