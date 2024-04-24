<?php
require_once '../classes/db_classes.php'; 

$database = Database::getInstance();

$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$products = $database->select("products");

foreach ($products as &$product) {
    $category_id = $product['category_id'];
    $category = $database->select("categories", "name", "id = $category_id");
    $product['category_name'] = $category[0]['name'];
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Products List</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Products List</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products as $product):
                        $product_info = $product['id'];
                        $delete_url = "../handlers/delete_product_handler.php?id={$product_info}";
                        // $edit_url = "update_product.php?id={$url_query_string}";
                        
                    ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="max-width: 100px;"></td>
                            <td><?php echo $product['category_name']; ?></td>
                            <td><a href="<?php echo $delete_url; ?>" class='btn btn-danger'>Delete</a></td>


                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</body>
</html>
