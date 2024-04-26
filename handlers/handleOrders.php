<?php
require_once '../App.php';

if ($request->ispost()) {
    // Handle order confirmation and insertion into the database
    $product_id = $request->post('product_id');
    $quantity = $request->post('quantity');
    $comments = $request->post('comments');
    $room_id = $request->post('room_id');
    
    // Calculate total amount based on product price and quantity
    $product = $database->selectById("products", $product_id);
    $total_amount = $product['price'] * $quantity;
    
    // Insert order into the database
    $table = 'orders';
    $columns = 'user_id, order_date, total_amount, notes, room_id, status';
    $values = '1, NOW(), ?, ?, ?, ?';
    $result = $database->execute($table, $columns, $values, [$total_amount, $comments, $room_id, 'pending']);
    
    if ($result) {
        echo "Order placed successfully!";
    } else {
        echo "Failed to place order.";
    }
}
?>
