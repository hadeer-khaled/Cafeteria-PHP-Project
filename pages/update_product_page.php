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
<?php
session_start();
if ($_SESSION["user_role"] != "admin") {
    header("Location: login.php"); 
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>

<body>
<?php
    require '../inc/admin_navbar.php';
    ?>
      <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card form-shadow">
                    <div class="card-header">
                        <h2 class="text-center main-text-color">Edit Product</h2>
                    </div>
                    <div class="card-body">
                        <form action="../handlers/update_product_handler.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <div class="form-group">
                                <label for="product_name">Product Name:</label>
                                <input type="text" class="form-control" id="product_name" name="name" 
                                placeholder="ex: Mango juice" value="<?php echo $product['name']; ?>" required pattern="[A-Za-z\s]*">
                            </div>
                            <div class="form-group mt-4">
                                <label for="product_price">Product Price:</label>
                                <input type="number" class="form-control" id="product_price" name="price" 
                                placeholder="ex: 90" value="<?php echo $product['price']; ?>" required min="0">
                            </div>
                            <div class="form-group mt-4">
                                <label for="product_stock">Product Stock:</label>
                                <input type="number" class="form-control" id="product_stock" name="stock" 
                                placeholder="ex: 90" value="<?php echo $product['stock']; ?>" required min="0">
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

                            <!-- <div class="form-group mt-4">
                                <label for="product_image">Product Image:</label>
                                <input type="file" class="form-control-file" id="product_image" name="image" required>
                            </div>
                             -->
                  
                            <div class="text-center mt-4">
                                <button type="submit" class="btn form-btn">Edit Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
}
?>




            





