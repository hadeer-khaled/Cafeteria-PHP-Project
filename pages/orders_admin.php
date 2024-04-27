<?php
require_once '../classes/db_classes.php'; 
session_start();

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$orders = $database->select("orders");

$productsWithCategories = [];
$baseImagePath = "../assets/images/";


if (!empty($orders)) {
    $OrdersToDisplay = []; 
    foreach ($orders as $order) {
        $order_id = $order['id'];
        $order_date = $order['order_date'];
        $customer = $database->selectById("users", $order['user_id']);     
        $customer_name = $customer['username'];
        $room = $order['room_id'];
        $status = $order['status'];
        $total = $order['total_amount'];

        $OrdersToDisplay[] = [
            'order_id' => $order_id,
            'customer_name' => $customer_name,
            'order_date' => $order_date,
            'room' => $room,
            'status' => $status,
            'total' => $total
        ];
    }

    // var_dump($OrdersToDisplay);
}


?>


<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
.product-image {
    width: 100px; 
    height: auto; 
    display: block;
    margin: 0 auto;
    border-radius: 5px;
    position: relative; /* Position the image container */
  }

  .price-tag {
    position: absolute; /* Position the price tag absolutely */
    top: 0; /* Align to the top */
    right: 0; /* Align to the right */
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    color: white; /* Text color */
    padding: 4px 8px; /* Padding for the tag */
    border-radius: 0 0 0 5px; /* Rounded corners on the left side */
  }

  .product-card{
    width: 100px;
    margin:20px;
    display: inline-block;
  }

  .total-price {
    position: relative; /* Position the total price text absolutely */
    bottom: 0; /* Align to the bottom */
    right: -1000px;
    margin: 10px; /* Add some margin for spacing */
  }
    </style>
</head>
<body>
    
<?php
    require '../inc/admin_navbar.php';
    ?>
    <div class="container mt-5">
        <?php if (empty($OrdersToDisplay)): ?>
            <div class="m-auto d-flex align-items-baseline text-center" style = "width:fit-content;">
                <h2 class="text-center mx-2">You have no orders yet. </h2>
                <div class="rounded-circle p-2" style ="width: fit-content; background-color: #BA6644;">
                    <a href="<?php echo "add_order_page.php"; ?>">
                        <i class="fa-solid fa-plus" style="color:white;font-size: 23px;"></i>
                    </a>
                </div>

            </div>       
        <?php else: ?>
            <h2 class="text-center" >Orders list</h2>
            <div class="table-responsive" style="position:relative; ">
            <div class="rounded-circle p-2 " style =" position:absolute;right: 0px;  width: fit-content; background-color: #BA6644;">
                    <a href="<?php echo "add_order_page.php"; ?>">
                        <i class="fa-solid fa-plus" style="color:white;font-size: 20px;"></i>
                    </a>
            </div>      
            <?php foreach ($OrdersToDisplay as $order): ?>
                <table class="table table-striped mt-2" style="margin-bottom: 50px;">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order date</th>
                            <th>customer name</th>
                            <th>Room</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td><?php echo $order['customer_name']; ?></td>
                            <td><?php echo $order['room']; ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <a href="deliver_order_page.php?id=<?php echo $order['order_id']; ?>" class="btn btn-success">deliver</a>
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div>
                                    <div class="products-section">
                                        <div class="product-card">
                                            <div style="position: relative;">
                                                <img class="product-image" src="https://media.wired.com/photos/598e35fb99d76447c4eb1f28/master/pass/phonepicutres-TA.jpg" alt="">
                                                <span class="price-tag">$5.00</span>
                                                <p class="product-name">coffee</p>
                                                <span class="product-quantity">Items: <strong>1</strong></span>
                                            </div>
                                        </div>
                                        <div class="product-card">
                                            <div style="position: relative;">
                                                <img class="product-image" src="https://media.wired.com/photos/598e35fb99d76447c4eb1f28/master/pass/phonepicutres-TA.jpg" alt="">
                                                <span class="price-tag">$5.00</span>
                                                <p class="product-name">coffee</p>
                                                <span class="product-quantity">Items: <strong>1</strong></span>
                                            </div>
                                        </div>
                                    </div>    
                                    <p class="total-price"><strong>Order Total: $10.00</strong></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                        
                        
                        
                </table>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>

    </div>
</body>
</html>


