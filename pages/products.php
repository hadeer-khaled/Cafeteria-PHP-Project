<?php
require_once '../App.php'; 
;

$searchQuery = $request->post('search');

if ($searchQuery) {
    $_SESSION['searchQuery'] = $searchQuery;
} else {
    if (isset($_SESSION['searchQuery'])) {
        unset($_SESSION['searchQuery']);
    }
}

if (isset($_SESSION['searchQuery'])) {
    $searchQuery = $_SESSION['searchQuery'];
    $sql = "SELECT * FROM products WHERE name LIKE '%$searchQuery%'";

    $statement = $database->prepare($sql);

    $statement->execute();

    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    unset($_SESSION['searchQuery']);

    $products = $database->select("products");

}

$productsWithCategories = [];

if (!empty($products)) {
    foreach ($products as $product) {
        $category_id = $product['category_id'];
        $category = $database->selectById("categories", $category_id);        
        if (!empty($category)) {
            $product['category_name'] = $category['name'];
            $productsWithCategories[] = $product;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/productCard.css">
</head>
<body>
    <section class="menu-area" id="coffee">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-60 col-lg-10">
                    <div class="py-5 title text-center">
                        <h1 class="mb-10 mt-20 display-5">Coffee Shop Menu Bootstrap 4.5</h1>
                        <p class="lead">TAGLINE GOES HERE</p>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-md-12">
                <form action="products.php" method="post">
                        <div class="form-group">
                            <label for="search">Search Product:</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Enter product name">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <?php if (!empty($productsWithCategories)): ?>
                    <?php foreach ($productsWithCategories as $product): ?>
                    <div class="col-lg-4 mb-4">
                        <div class="single-menu">
                            <div class="title-div justify-content-between d-flex">
                                <h4><?= $product['name']; ?></h4>
                                <p class="price float-right">$<?= $product['price']; ?></p>
                            </div>
                            <img src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>" style="max-width: 100px;">
                            <form action="../handlers/handleCart.php" method="post" name="esraa" class="mt-3">
                                
                                <input type="hidden" name="productId" value="<?= $product['id']; ?>">
                                <div class="form-group">
                                    <label for="quantity<?= $product['id']; ?>">Quantity:</label>
                                    <input type="number" name="quantity" id="quantity<?= $product['id']; ?>" class="form-control" value="1" min="1">
                                </div>
                                <button type="submit" class="btn btn-primary" name="addToCart">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-md-12">
                        <p>No products found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>
