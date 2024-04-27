<?php
    require_once '../inc/admin_navbar.php';
    require_once '../App.php'; 
    $baseImagePath = "../assets/images/";

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
    <link rel="stylesheet" type="text/css" href="../assets/css/Search.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/productCard.css">
    <link href="../assets/css/style.css" rel="stylesheet">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>


    <section class="menu-area" id="coffee">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-60 col-lg-10">
                <div class="typing-animation">
                            <h1 class="mb-10 mt-20 display-5">Coffee Shop Menu</h1>
                            <p class="lead">What Are You Looking For?</p>
                        </div>

                </div>
            </div> 
            <div class="row">
                <div class="col-md-12">
                <form action="index.php" method="post">
                    
                <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-12 search-container">
                <div class="search">
                    <form action="index.php" method="post">
                        <input class="search_input" type="text" name="search" placeholder="Search here...">
                        <button type="submit" class="search_icon"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                            <img  src="<?php echo $baseImagePath . $product['image']; ?>"
                                    alt="<?php echo $product['name']; ?>"
                                    style="max-width: 200px;">                            
                                <form action="../handlers/handleCart.php" method="post" name="esraa" class="mt-3">
                                <input type="hidden" name="productId" value="<?= $product['id']; ?>">
                                <div class="form-group">
                                    <label for="quantity<?= $product['id']; ?>">Quantity:</label>
                                    <input type="number" name="quantity" id="quantity<?= $product['id']; ?>" class="form-control" value="1" min="1">
                                </div>
                                <button type="submit" class="btn form-btn" name="addToCart">Add to Cart</button>
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
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
</body>
</html>
