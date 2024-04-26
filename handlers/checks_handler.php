<?php
require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

$database = Database::getInstance();
$database->connect("localhost", "php_php", 'Password$ecure123', "cafeteria");

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;

$start_date = htmlspecialchars($start_date);
$end_date = htmlspecialchars($end_date);
$user_id = htmlspecialchars($user_id);
echo "start query";



$orders = $database->getOrdersByCriteria($start_date, $end_date, $user_id);


var_dump($orders);

// if ($orders) {
//     foreach ($orders as $order) {
//         echo "Order ID: " . $order['order_id'] . "<br>";
//         echo "Order Date: " . $order['order_date'] . "<br>";
//         echo "Total Amount: $" . $order['total_amount'] . "<br>";
//         echo "Notes: " . $order['notes'] . "<br>";
//         echo "User: " . $order['username'] . "<br>";
//         echo "<hr>";
//     }
// } else {
//     echo "No orders found for the selected criteria.";
// }

?>
