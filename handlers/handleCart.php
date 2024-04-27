<?php
require_once '../App.php';

if ($request->ispost()) {
    if (isset($_POST['addToCart'])) {
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];

        $cartItems = $session->get('cart');
        $productExists = false;
        foreach ($cartItems as $item) {
            if ($item['id'] == $productId) {
                $productExists = true;
                $item['quantity'] += $quantity;
                break;
            }
        }

        if (!$productExists) {
            $database = Database::getInstance();
            $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $product = $database->selectById("products", $productId);

            $cartItem = [
                'id' => $productId,
                'quantity' => $quantity,
                'name' => $product['name'],
                'price' => $product['price']
            ];

            $session->push('cart', $cartItem);
        } else {
            $session->add('cart', $cartItems);
        }

        $request->redirect('../pages/Cart.php');
        exit(); 
     } else {
        echo "Invalid action";
    }
} else {
    echo "Not a post request";
}
?>
