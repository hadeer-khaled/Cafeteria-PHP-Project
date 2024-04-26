<?php
require_once '../classes/db_classes.php'; 

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$products = $database->select("products");

$productsWithCategories = [];
$baseImagePath = "../assets/images/";


if (!empty($products)) {
    foreach ($products as $product) {
        $category_id = $product['category_id'];
        $category = $database->selectById("categories", $category_id);        
        if (!empty($category)) {
            $product['category_name'] = $category['name'];
            $productsWithCategories[] = $product;
        }
    }
    // var_dump( $productsWithCategories);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Products List</title>
</head>
<body>
<?php
    require '../inc/admin_navbar.php';
    ?>
    <div class="container mt-5">
        <?php if (empty($productsWithCategories)): ?>
            <div class="m-auto d-flex align-items-baseline text-center" style = "width:fit-content;">
                <h2 class="text-center mx-2">Product List is empty. </h2>
                <div class="rounded-circle p-2" style ="width: fit-content; background-color: #BA6644;">
                    <a href="<?php echo "add_product_page.php"; ?>">
                        <i class="fa-solid fa-plus" style="color:white;font-size: 23px;"></i>
                    </a>
                </div>

            </div>        
        <?php else: ?>
            <h2 class="text-center" >Products List</h2>
            <div class="table-responsive" style="position:relative; ">
            <div class="rounded-circle p-2 " style =" position:absolute;right: 0px;  width: fit-content; background-color: #BA6644;">
                    <a href="<?php echo "add_product_page.php"; ?>">
                        <i class="fa-solid fa-plus" style="color:white;font-size: 20px;"></i>
                    </a>
                </div>      
            <table class="table table-striped mt-2" >
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
                        <?php foreach ($productsWithCategories as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td><?php echo $product['name']; ?></td>
                                <td><?php echo $product['price']; ?></td>
                                <td><img  src="<?php echo $baseImagePath . $product['image']; ?>"
                                    alt="<?php echo $product['name']; ?>"
                                    style="max-width: 50px;">
                                </td>
                                <td><?php echo $product['category_name']; ?></td>
                                <td>
                                    <a href="<?php echo "../handlers/delete_product_handler.php?id={$product['id']}"; ?>" >
                                    <i class="fa-solid fa-trash-can"  style = "font-size: 20px;color: #8B322C;" ></i></a>
                                    |
                                    <a href="<?php echo "update_product_page.php?id={$product['id']}"; ?>" >
                                    <i class="fa-solid fa-pen-to-square" style = "font-size: 20px;color: #1A4D2E;"></i></a>
                            
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

    </div>
</body>
</html>

