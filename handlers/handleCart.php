<?php
require_once '../App.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the action is to add a new item to the cart
    if (isset($_POST['addToCart'])) {
        // Get product details from the form
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];

        // Fetch product details from the database (you can skip this step since we're using session)
        $database = Database::getInstance();
        $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $product = $database->selectById("products", $productId);

        // Prepare the cart item
        $cartItem = [
            'id' => $productId,
            'quantity' => $quantity,
            'name' => $product['name'],
            'price' => $product['price']
        ];

        // Add the cart item to the session using the push method
        $session->push('cart', $cartItem);

        // Redirect to the cart page
        header('Location: ../pages/Cart.php');
        exit(); // Ensure script execution stops after redirection
    } elseif (isset($_POST['removeItemId'])) {
        // Remove item from the cart
        $removeItemId = $_POST['removeItemId'];

        // Get the cart items from the session
        $cartItems = $session->get('cart');

        // Loop through the cart items and remove the item with the specified ID
        foreach ($cartItems as $key => $item) {
            if ($item['id'] == $removeItemId) {
                unset($cartItems[$key]);
            }
        }

        // Update the cart items in the session
        $session->add('cart', $cartItems);

        // Redirect to the cart page
        header('Location: ../pages/Cart.php');
        exit(); // Ensure script execution stops after redirection
    } elseif (isset($_POST['updateItemId'])) {
        // Update quantity of an item in the cart
        $updateItemId = $_POST['updateItemId'];
        $newQuantity = $_POST['newQuantity'];

        // Get the cart items from the session
        $cartItems = $session->get('cart');

        // Loop through the cart items and update the quantity of the item with the specified ID
        foreach ($cartItems as &$item) {
            if ($item['id'] == $updateItemId) {
                $item['quantity'] = $newQuantity;
            }
        }

        // Update the cart items in the session
        $session->add('cart', $cartItems);

        // Redirect to the cart page
        header('Location: ../pages/Cart.php');
        exit(); // Ensure script execution stops after redirection
    } else {
        // If none of the above actions are triggered, it's not a valid request
        echo "Invalid action";
    }
} else {
    // If the request method is not POST, display an error message
    echo "Not a post request";
}
?>
