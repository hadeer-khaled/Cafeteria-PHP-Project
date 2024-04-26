<?php
require_once '../base.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checks</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php
  require '../inc/admin_navbar.php';
?>
<div class="container">
    <div class="row justify-content-center">
        <h2 class="text-center">Checks</h2>
        <form class="card mb-3" id="search-form">
            <div class="card-body">
                <div class="row w-50">
                    <div class="col">
                        <input type="date" class="form-control" name="start_date" id="start_date" placeholder="Date From">
                    </div>
                    <span class="text-primary">To:</span>
                    <div class="col">
                        <input type="date" class="form-control" name="end_date" id="end_date" placeholder="Date To">
                    </div>
                    <span class="text-primary">OR:</span>
                    <div class="col">
                        <select name="user_id" id="user_id" class="form-control form-select">
                            <option value="">Select User</option>
                            <?php
                            require_once '../classes/db_classes.php'; 
                            $database = Database::getInstance();
                            $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                            $users = $database->select("users");
                            foreach ($users as $user):
                                echo "<option value='" . $user['id'] . "'>" . $user['username'] . "</option>";
                            endforeach; 
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <button type="button" id="search-button" class="btn btn-outline-success">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="row justify-content-center">
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Order Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="orders-table-body">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('search-button').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('search-form'));

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../handlers/checks_handler.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); 
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('orders-table-body').innerHTML = xhr.responseText;
            }
        };
        xhr.send(formData);
    });

    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('start_date').value = today;
        document.getElementById('end_date').value = today;
    });
</script>
</body>
</html>
