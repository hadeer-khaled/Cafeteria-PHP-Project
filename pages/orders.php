<?php
require_once '../App.php';

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Process adding item to cart when a product is clicked on the home page
if ($request->ispost() && $request->post('productId')) {
    $productId = $request->post('productId');
    $quantity = 1; // Default quantity is 1

    // Check if quantity is specified in the request
    if ($request->post('quantity')) {
        $quantity = $request->post('quantity');
    }

    // Fetch product details from the database
    $product = $database->selectById("products", $productId);

    if ($product) {
        // Insert the cart item into the order_items table
        $cartItemData = [
            'product_id' => $productId,
            'quantity' => $quantity,
            'product_price' => $product['price'], // Assuming you want to store the product price in the order
        ];

        // Insert the cart item data into the order_items table
        $result = $database->insert("order_items", array_keys($cartItemData), array_values($cartItemData));

        if ($result) {
            echo "Product added to cart successfully.";
        } else {
            echo "Error adding product to cart.";
        }
    } else {
        // Product not found, handle error
        echo "Product not found.";
    }
}

// Fetch cart items for the current user
$userId = 1; // Assuming a user ID of 1 for demonstration purposes, replace with actual user ID
$cartItems = $database->select("order_items", "*", ["user_id" => $userId]);

$totalPrice = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Select Your Order</h1>
        <form action="Cart.php" method="post">
            <div class="row">
                <?php foreach ($productsWithCategories as $product): ?>
                    <div class="col-lg-4">
                        <div class="single-menu">
                            <div class="title-div justify-content-between d-flex">
                                <h4><?= $product['name']; ?></h4>
                                <p class="price float-right">$<?= $product['price']; ?></p>
                            </div>
                            <img src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>" style="max-width: 100px;">
                            <input type="hidden" name="productId" value="<?= $product['id']; ?>">
                            <input type="number" name="quantity" value="1" min="1"> <!-- Input field for quantity -->
                            <button type="submit" name="addToCart">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
        <hr>
        <h1 class="mt-5">Your Cart</h1>
        <form action="ConfirmOrder.php" method="post">
            <select name="room">
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room['id']; ?>"><?= $room['room_number']; ?></option>
                <?php endforeach; ?>
            </select>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <?php 
                            // Fetch product details from the products table
                            $product = $database->selectById("products", $item['product_id']);
                            ?>
                            <td><?= $product['name']; ?></td>
                            <td>$<?= $item['product_price']; ?></td>
                            <td>
                                <input type="number" name="quantity[]" value="<?= $item['quantity']; ?>" min="1">
                                <input type="hidden" name="productId[]" value="<?= $product['id']; ?>">
                            </td>
                            <td>$<?= $item['product_price'] * $item['quantity']; ?></td>
                            <td>
                                <button type="submit" class="btn btn-danger btn-sm" name="removeItemId" value="<?= $item['id']; ?>">Remove</button>
                            </td>
                        </tr>
                        <?php 
                        // Calculate total price
                        $totalPrice += $item['product_price'] * $item['quantity'];
                        ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-3">
                <h4>Total Price: $<?= $totalPrice; ?></h4>
            </div>
            <div class="mt-3">
                <label for="notes">Order Notes:</label>
                <textarea name="notes" id="notes" rows="4" class="form-control"></textarea>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Confirm Order</button>
            </div>
        </form>
    </div>
</body>
</html>
