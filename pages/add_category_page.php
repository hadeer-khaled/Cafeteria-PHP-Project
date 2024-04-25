<?php
require_once '../base.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Category Form</title>
    <link href="../assets/css/style.css" rel="stylesheet">
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
                        <h2 class="text-center">Add a Category</h2>
                    </div>
                    <div class="card-body">
                        <form action="../handlers/add_category_handler.php" method="POST">
                            <div class="form-group">
                                <label for="category_name" class="mb-1">Category Name:</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn form-btn mt-4">Add Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
