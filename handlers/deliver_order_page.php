    <?php
    require_once '../classes/db_classes.php'; 
    

    $database = Database::getInstance();
    $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    $fields = "status = 'delivered'"; // Assuming 'status' is the column to be updated
    $delivered = $database->update("orders", $_GET['id'], $fields);

    if ($delivered) {
        header('Location: ../pages/orders_admin.php');
    } else {
        echo "Error: Order could not be delivered.";
    }