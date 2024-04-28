<?php
require_once '../classes/db_classes.php'; 

$database = Database::getInstance();
$database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$categories = $database->select("categories");
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
    <title>Categories List</title>
</head>
<body>
<?php
    require '../inc/admin_navbar.php';
    ?>
    <div class="container mt-5">
        <?php if (empty($categories)): ?>
            <div class="m-auto d-flex align-items-baseline text-center" style = "width:fit-content;">
                <h2 class="text-center mx-2">Categories List is empty. </h2>
                <div class="rounded-circle p-2" style ="width: fit-content; background-color: #BA6644;">
                    <a href="<?php echo "add_category_page.php"; ?>">
                        <i class="fa-solid fa-plus" style="color:white;font-size: 23px;"></i>
                    </a>
                </div>

            </div>        
        <?php else: ?>
            <h2 class="text-center" >Categories List</h2>
            <div class="table-responsive" style="position:relative; ">
            <div class="rounded-circle p-2 " style =" position:absolute;right: 0px;  width: fit-content; background-color: #BA6644;">
                    <a href="<?php echo "add_category_page.php"; ?>">
                        <i class="fa-solid fa-plus" style="color:white;font-size: 20px;"></i>
                    </a>
                </div>      
            <table class="table table-striped mt-2" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo $category['id']; ?></td>
                                <td><?php echo $category['name']; ?></td>                            
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

    </div>
</body>
</html>

<?php
}
?>