<?php
require_once '../App.php';

if ($request->ispost()) {
    if ($request->post('removeItemId')){
        $removeItemId = $_POST['removeItemId'];

        $cartItems = $session->get('cart');

        foreach ($cartItems as $key => $item) {
            if ($item['id'] == $removeItemId) {
                unset($cartItems[$key]);
            }
        }

        $session->add('cart', $cartItems);

        $request->redirect('../pages/Cart.php');
        exit(); 
    } elseif ($request->post('updateItemId')) {
        $updateItemId = $_POST['updateItemId'];
        $newQuantity = $_POST['quantity'][$updateItemId];

        $cartItems = $session->get('cart');

        foreach ($cartItems as &$item) {
            if ($item['id'] == $updateItemId) {
                $item['quantity'] = $newQuantity;
            }
        }

        $session->add('cart', $cartItems);

        $request->redirect('../pages/Cart.php');
        exit(); 
    }
}

$cartItems = $session->get('cart');
$totalPrice = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Order</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Confirm Your Order</h1>
        <?php if (!empty($cartItems)): ?>
        <form action="Cart.php" method="post">
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
                        <td><?= $item['name']; ?></td>
                        <td>$<?= $item['price']; ?></td>
                        <td>
                            <input type="number" name="quantity[<?= $item['id']; ?>]" value="<?= $item['quantity']; ?>" min="1">
                            <input type="hidden" name="productId[]" value="<?= $item['id']; ?>">
                        </td>
                        <td>$<?= $item['price'] * $item['quantity']; ?></td>
                        <td>
                            <button type="submit" class="btn btn-primary btn-sm" name="updateItemId" value="<?= $item['id']; ?>">Update</button>
                            <button type="submit" class="btn btn-danger btn-sm" name="removeItemId" value="<?= $item['id']; ?>">Remove</button>
                        </td>
                    </tr>
                    <?php 
                    // Calculate total price
                    $totalPrice += $item['price'] * $item['quantity'];
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
        <?php else: ?>
        <p>Your cart is empty</p>
        <?php endif; ?>
    </div>
</body>
</html>
