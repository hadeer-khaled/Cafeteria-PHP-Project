<?php
// session_start();
// if ($_SESSION["user_role"] != "admin") {
//     header("Location: login.php"); 
// }
require_once '../base.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Checks</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>

<div class="container-fluid">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="card mb-3">
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
                            $users = $database->select("users");
                            foreach ($users as $user):
                                echo "<option value='" . $user['id'] . "'>" . $user['username'] . "</option>";
                            endforeach; 
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn form-btn form-btn:hover">Search</button>
                    </div>
                </div>
            </div>
    </form>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row justify-content-between align-items-center">
                <h4 class="col" style="color:#202738">Checks</h4>
            </div>
        </div>

        <div class="card-body" >
            <table class="table table-bordered table-responsive">
                <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach($orders as $order): ?>
                        <tr>
                            <td colspan="2">
                                <div class="accordion accordion-flush" id="accordionExample">
                                    <div class="accordion-item m-4">
                                        <h2 class="accordion-header" id="heading<?= $order['user_id'] ?>">
                                            <button class="accordion-button collapsed border rounded" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $order['user_id'] ?>" aria-expanded="true" aria-controls="flush-collapse<?= $order['username'] ?>">
                                                <span class="col"><span class="text-secondary">Username: </span><?= $order['username'] ?></span>
                                                <span class="col"><span class="text-secondary">Total Price: </span><?= $order['total_amount'] ?> <span class="badge text-bg-success">$</span></span>
                                            </button>
                                        </h2>

                                        <div id="flush-collapse<?= $order['user_id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $order['user_id'] ?>" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <table class="table table-bordered table-hover table-responsive" style="height: 100px; overflow: scroll;">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Order ID</th>
                                                        <th scope="col">Order Date</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Details</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php  $user_id = $order['user_id']; 
                                                            foreach ($orders as $order): 
                                                                $url_query_string = $order['order_id'];
                                                                $details_url = "Details.php?id={$url_query_string}";
                                                            ?>
                                                        <tr>
                                                            <td><?= $order['order_id'] ?></td>
                                                            <td><?= $order['order_date'] ?></td>
                                                            <td><?= $order['status'] ?></td>
                                                            <?php echo "<td> <a href='{$details_url}' class= 'btn' style='background-color:#202738; color: white'> Details</a></td>";
                                                            ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="text-center">
                        <td colspan="2">
                            <h2>No Checks Found</h2>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
        document.addEventListener("DOMContentLoaded", function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('start_date').value = today;
        document.getElementById('end_date').value = today;
    });
</script>
</body>
</html>