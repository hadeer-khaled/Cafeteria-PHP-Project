<?php

require_once '../classes/db_classes.php'; 

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check if a date range is specified
if (isset($_GET['start']) && isset($_GET['end'])) {
    // Sanitize and validate the dates
    $start_date = $_GET['start'];
    $end_date = $_GET['end'];
    // Fetch orders within the specified date range
    $orders = $database->select("orders", "WHERE order_date BETWEEN '$start_date' AND '$end_date'");
} else {
    // Fetch all orders if no date range is specified
    $orders = $database->select("orders");
}

$user_id = 7; // Assuming the user ID is hardcoded for demonstration purposes

$totalAmount = 0; // Initialize total amount variable

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>My Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <!--ordertable-->
    <main class="my-orders my-5">
        <section class="main-padding">
            <div class="container py-5">
                <div>My orders</div>
                <div class="card-body">
                    <div class="card shadow p-3">
                        <form action="" method="GET" id="searchForm">
                            <input type="hidden" name="userId" value="<?= $user_id ?>" />
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="from-group">
                                        <label for="start">Date from:</label>
                                        <input type="date" class="form-control start" name="start" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="end">Date to:</label>
                                        <input type="date" class="form-control end" name="end" />
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-2">
                                    <button id="search" type="submit" class="btn btn-primary mx-2 text-light">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="main-padding">
            <div class="container">
                <div class="user-orders">
                    <table class="table table-hover shadow">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Order Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="orderTableBody">
                            <?php if (!empty($orders)) {
                                foreach ($orders as $order) { ?>
                                    <tr class="order">
                                        <td>
                                            <span><?= $order['order_date'] ?></span>
                                            <i class="fa fa-plus-square mx-5 toggle-details" data-order-id="<?= $order['id'] ?>"></i>
                                        </td>

                                        <td class="<?= strtolower($order['status']) ?>">
                                            <span><?= $order['status'] ?></span>
                                        </td>

                                        <td>
                                            <span><?= $order['total_amount'] ?></span> $
                                        </td>
                                        <td>
                                            <?php if ($order["status"] == 'Processing') { ?>
                                                <a href='../handlers/cancel_order_handler.php?id=<?= $order['id'] ?>' class='cancel btn btn-danger'>Cancel</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr class="order-details" id="orderDetails<?= $order['id'] ?>" style="display: none;">
                                        <td colspan="4">
                                            <!-- Order details will appear here -->
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $order_id = $order['id'];
                                                    // Fetch order items for this order
                                                    $orderItems = $database->select("order_items");
                                                    // Loop through order items and display them
                                                    foreach ($orderItems as $orderItem) {
                                                        // Fetch product name for this order item
                                                        $product_id = $orderItem['product_id'];
                                                        $product = $database->selectById("products", $product_id);
                                                        // Display order item details
                                                ?>
                                                        <tr>
                                                            <td><?= $product['name'] ?></td>
                                                            <td><?= $orderItem['product_price'] ?></td>
                                                            <td><?= $orderItem['quantity'] ?></td>
                                                            <td><?= $orderItem['product_price'] * $orderItem['quantity'] ?></td>
                                                        </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                            <?php }
                            } else { ?>
                                <div class="alert alert-warning" role="alert">No orders found.</div>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="total-price">
                        <h3 class="text-light">Total</h3>
                        <h4 class="text-light"><span id="totalAmount" class="text-light"><?= $totalAmount ?></span> $</h4>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        // Add event listener to toggle order details
        document.addEventListener("DOMContentLoaded", function() {
            const toggleDetailsButtons = document.querySelectorAll(".toggle-details");
            toggleDetailsButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const orderId = button.dataset.orderId;
                    const orderDetails = document.getElementById(`orderDetails${orderId}`);
                    orderDetails.style.display = orderDetails.style.display === "none" ? "table-row" : "none";
                });
            });
        });
    </script>
</body>

</html>
