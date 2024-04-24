
<?php
require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_class.php'; 


$database = Database::getInstance();

$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$categories = $database->select("categories")
?>
<!DOCTYPE html>

<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Add Product</h2>
                    </div>
                    <div class="card-body">
                        <form action="../handlers/product_handler.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="product_name">Product Name:</label>
                                <input type="text" class="form-control" id="product_name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="product_price">Product Price:</label>
                                <input type="number" class="form-control" id="product_price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="product_image">Product Image:</label>
                                <input type="file" class="form-control-file" id="product_image" name="image" required>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category:</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
