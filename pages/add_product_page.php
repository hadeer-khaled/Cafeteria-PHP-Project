
<?php
require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 


$database = Database::getInstance();

$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$categories = $database->select("categories")
?>
<?php
session_start();
if ($_SESSION["user_role"] != "admin") {
    header("Location: login.php"); 
} else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link href="../assets/css/style.css" rel="stylesheet">

</head>
<body>
<?php
    require '../inc/admin_navbar.php';
    ?>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card form-shadow">
                    <div class="card-header">
                        <h2 class="text-center main-text-color">Add Product</h2>
                    </div>
                    <div class="card-body">

                        <form action="../handlers/add_product_handler.php" method="POST" enctype="multipart/form-data" >
                                <div class="form-group">
                                    <label for="product_name">Product Name:</label>
                                    <input type="text" class="form-control" id="product_name" name="name" placeholder="ex: Mango juice" required pattern="[A-Za-z\s]*"> 
                                </div>
                                <div class="form-group mt-4">
                                    <label for="product_price">Product Price:</label>
                                    <input type="number" class="form-control" id="product_price" name="price" placeholder="ex: 90" required min="0">
                                </div>
                                <div class="form-group mt-4">
                                    <label for="product_stock">Stock:</label>
                                    <input type="number" class="form-control" id="product_stock" name="stock" placeholder="ex: 50" required min="0">
                                </div>
                                <div class="form-group mt-4">
                                    <label for="category_id">Category: <a href="add_category_page.php">Add Category</a> </label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mt-4">
                                    <label for="product_image">Product Image:</label>
                                    <input type="file" class="form-control-file" id="product_image" name="image" required accept="image/*">
                                </div>         
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn form-btn">Add Product</button>
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