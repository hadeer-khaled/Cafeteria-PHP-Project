<?php
require_once '../classes/db_classes.php'; 

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$orders = $database->select("orders");
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
                                            <i class="fa-solid fa-square-caret-down mx-5 toggle-details" data-order-id="<?= $order['id'] ?>"></i>
                                        </td>

                                        <td class="<?= strtolower($order['status']) ?>">
                                            <span><?= $order['status'] ?></span>
                                        </td>

                                        <td>
                                            <span><?= $order['total_amount'] ?></span> $
                                        </td>
                                        <td>
                                            <?php if ($order["status"] == 'processing') { ?>
                                                <a href='../handlers/cancel_order_handler.php?id=<?= $order['id'] ?>' class='cancel btn btn-danger'>Cancel</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr class="order-details" id="orderDetails<?= $order['id'] ?>" style="display: none;">
                                        <td colspan="4">
                                            <!-- order details -->
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
                                                  $order_items = $database->selectOrderItemsByOrderId($order['id']);
                                                  $displayed_products = []; 

                                                  if (!empty($order_items)) {
                                                    foreach ($order_items as $item) {
                                                      $product_id = $item['product_id'];
                                                      $product = $database->selectById("products", $product_id);
        
                                                      if (!empty($product) && !in_array($product_id, $displayed_products)) {
                                                        $displayed_products[] = $product_id;
                                                ?>
                                                <tr>
                                                  <td><?= $product['name'] ?></td>
                                                  <td><?= $product['price'] ?></td>
                                                  <td><?= $item['quantity'] ?></td>
                                                  <td><?= $product['price'] * $item['quantity'] ?></td>
                                                </tr>
                                            <?php
                                          }
                                        }
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
