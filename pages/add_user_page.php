<?php
    // Check if there are any errors and old data passed via GET request
    require_once '../base.php';
    if(isset($_GET['errors'])){
        $errors = json_decode($_GET["errors"], true);
    }

    if(isset($_GET['old_data'])){
        $old_data = json_decode($_GET["old_data"], true);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Register an Account</h1>
    <form action="../handlers/user_handler.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label"> Name</label>
            <input type="text" name="name" class="form-control" id="name"
            value="<?php echo isset($old_data['name']) ? $old_data['name'] : ''; ?>"
            >
            <?php if(isset($errors['name'])): ?>
                <div class="text-danger"><?php echo $errors['name']; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email"
            value="<?php echo isset($old_data['email']) ? $old_data['email'] : ''; ?>"
            >
            <?php if(isset($errors['email'])): ?>
                <div class="text-danger"><?php echo $errors['email']; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password"
            value="<?php echo isset($old_data['password']) ? $old_data['password'] : ''; ?>"
            >
            <?php if(isset($errors['password'])): ?>
                <div class="text-danger"><?php echo $errors['password']; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"
            value="<?php echo isset($old_data['confirmPassword']) ? $old_data['confirmPassword'] : ''; ?>"
            >
            <?php if(isset($errors['confirmPassword'])): ?>
                <div class="text-danger"><?php echo $errors['confirmPassword']; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="roomNo" class="form-label">Room No</label>
            <select name="roomNo" class="form-select" id="roomNo">
                <option value="1" <?php echo (isset($old_data['roomNo']) && $old_data['roomNo'] == '1') ? 'selected' : ''; ?>>1</option>
                <option value="2" <?php echo (isset($old_data['roomNo']) && $old_data['roomNo'] == '2') ? 'selected' : ''; ?>>2</option>
                <option value="3"category_handler <?php echo (isset($old_data['roomNo']) && $old_data['roomNo'] == '3') ? 'selected' : ''; ?>>3</option>
            </select>
            <?php if(isset($errors['roomNo'])): ?>
                <div class="text-danger"><?php echo $errors['roomNo']; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Profile picture</label>
            <input type="file" name="image" id="image" accept="image/*" required 
                   class="form-control"  aria-describedby="emailHelp">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
