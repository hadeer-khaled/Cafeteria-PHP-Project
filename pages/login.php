<?php

session_start();

if (isset($_SESSION['email'])) {
    header('Location: products_table.php'); 
    exit();
}

require_once '../handlers/loginValidation.php';


$old_data = isset($_SESSION['old_data']) ? $_SESSION['old_data'] : [];
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['old_data'], $_SESSION['errors']); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Login</h2>
                </div>
                <div class="card-body">
                    <?php if (isset($errors['login'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errors['login']; ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email" 
                                value="<?php echo isset($old_data['email']) ? $old_data['email'] : ''; ?>" required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['email']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Enter your password" id="password" name="password" required >
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="showPasswordBtn" onclick="togglePasswordVisibility()">Show</button>
                                </div>
                            </div>
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['password']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <a href="forgot_password.php">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }
</script>
</body>
</html>
