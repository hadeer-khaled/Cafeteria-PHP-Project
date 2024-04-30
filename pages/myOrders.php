<?php
require_once '../classes/db_classes.php'; 

session_start();
$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$user_id = $_SESSION["user_id"];

if(isset($_GET['start']) && isset($_GET['end'])) {
    $start_date = $_GET['start'];
    $end_date = $_GET['end'];
    $orders = $database->getOrdersByCriteria($start_date, $end_date, $user_id);
} else {
    $orders = $database->getOrdersByCriteria(null, null, $user_id);

}

$totalAmountOfAllOrders = 0;
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
    <?php
     require_once '../inc/user_navbar.php';
    ?>
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
                                    <div class="form-group">
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
                                    <button id="search-button" type="submit" class="btn form-btn form-btn:hover">Search</button>
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
                        <tbody id="orders-table-body">
                            <?php if (!empty($orders)) {
                                foreach ($orders as $order) { 
                                    $orderId = isset($order['order_id']) ? $order['order_id'] : '';
                                    $order_items = $database->selectOrderItemsByOrderId($orderId);
                                    $total_amount = 0;
                                    ?>
                                    <tr class="order">
                                        <td>
                                            <span><?= $order['order_date'] ?></span>
                                            <i class="fa-solid fa-square-caret-down mx-5 toggle-details" data-order-id="<?= $orderId ?>"></i>
                                        </td>

                                        <td class="<?= strtolower($order['status']) ?>">
                                            <span><?= $order['status'] ?></span>
                                        </td>

                                        <td>
                                            <?php
                                            foreach ($order_items as $item) {
                                                $product = $database->selectById("products", $item['product_id']);
                                                $total_amount += $product['price'] * $item['quantity'];
                                            }
                                            $totalAmountOfAllOrders += $total_amount;
                                            ?>
                                            <span><?= $total_amount ?></span> $
                                        </td>
                                        <td>
                                            <?php if ($order["status"] == 'pending') { ?>
                                                <a href='../handlers/cancel_order_handler.php?id=<?= $orderId ?>' class='cancel btn btn-danger'>Cancel</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr class="order-details" id="orderDetails<?= $orderId ?>" style="display: none;">
                                        <td colspan="4">
                                            <!-- order details -->
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Order Name</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($order_items)) {
                                                        foreach ($order_items as $item) {
                                                            $product = $database->selectById("products", $item['product_id']);
                                                    ?>
                                                            <tr>
                                                                <td><?= $product['name'] ?></td>
                                                                <td><?= $product['price'] ?> $</td>
                                                                <td><?= $item['quantity'] ?></td>
                                                                <td><?= $product['price'] * $item['quantity'] ?> $</td>
                                                            </tr>
                                                    <?php }
                                                    } else {
                                                        echo "<tr><td colspan='4'>No items found for this order.</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                            <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-warning" role="alert">No orders found.</div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <?php if (!empty($orders)) { ?>
                        <div>Total: <?= $totalAmountOfAllOrders ?> $</div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </main>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleDetailsButtons = document.querySelectorAll(".toggle-details");
            toggleDetailsButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const orderId = button.dataset.orderId;
                    const orderDetails = document.getElementById(`orderDetails${orderId}`);
                    orderDetails.style.display = orderDetails.style.display === "none" ? "table-row" : "none";
                    if (orderDetails.style.display !== "none") {
                        fetchOrderDetails(orderId);
                    }
                });
            });

        });
    </script>
</body>
</html>
