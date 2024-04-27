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

$orders = $database->getOrdersByCriteria($start_date, $end_date, $user_id);

if ($orders) {
    foreach ($orders as $order) {
        echo "<tr>";
        echo "<td>" . $order['username']. "</td>";
        echo "<td>" . $order['order_date'] . "</td>";
        echo "<td>" . $order['status']  . "</td>";
        echo "<td>" . $order['total_amount'] . "</td>";
        echo "<td>". "Details" . "</td>";
        echo "</tr>";
    }
} else {
    echo "No orders found for the selected criteria.";
}
?>
