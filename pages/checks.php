<?php
// session_start();
// if ($_SESSION["user_role"] != "admin") {
//     header("Location: login.php"); 
// }

require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

$database = Database::getInstance();
$database->connect("localhost", "php_php", 'Password$ecure123', "cafeteria");

if(isset($_GET['start_date']) && isset($_GET['end_date']) && isset($_GET['user_id']) && !empty($_GET['start_date']) && !empty($_GET['end_date']) && !empty($_GET['user_id'])){

    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $user_id = $_GET['user_id'];

    $orders = $database->getOrdersByCriteria($start_date, $end_date, $user_id);
}else {
$allorders = $database->select("orders");

$orders = [];

if (!empty($allorders)) {
    foreach ($allorders as $order) {
        $user_id = $order['user_id'];
        $user = $database->selectById("users", $user_id);        
        if (!empty($user)) {
            $order['username'] = $user['username'];
            $order['user_id'] = $user['id'];
            $order['order_id'] = $order['id'];
            $orders[] = $order;
        }
    }
}
}

include "../handlers/checks_handler.php";

