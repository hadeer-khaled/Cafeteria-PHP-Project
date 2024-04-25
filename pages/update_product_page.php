<?php

require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 

$product_id = $_GET['id'];

try {
    $database = Database::getInstance();
    $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $product = $database->selectById("products", $product_id);
    $categories = $database->select("categories"); // Fetch categories from the database
} catch(PDOException $e) {
    echo $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>

<body>
    <div class="container">
        <h2 class="mt-5 mb-4">Update Product</h2>
        <form action="../handlers/update_product_handler.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name"
                value="<?php echo $product['name']; ?>">
            </div>

            <div class="form-group mt-4">
                <label for="product_price">Product Price:</label>
                <input type="number" class="form-control" id="product_price" name="price" placeholder="ex: 90" 
                value="<?php echo $product['price']; ?>" required>
            </div>
            
            <div class="form-group mt-4">
                <label for="category_id">Category:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                            <?php echo $category['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>
