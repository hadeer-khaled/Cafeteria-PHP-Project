<?php
require_once '../env.php';
require_once '../base.php';
require_once '../classes/db_classes.php'; 
$edit_data = [];
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $database = Database::getInstance();
    $database->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $user= $database->selectById("users", $user_id);
    
    if ($user) {
        
            $edit_data['id'] = $user['id'];
            $edit_data['username'] = $user['username'];
            $edit_data['email'] = $user['email'];
            $edit_data['password'] = $user['password']; 
            $edit_data['confirmPassword'] = $user['password']; 
            $edit_data['room_id'] = $user['room_id'];
            $edit_data['image'] = $user['image'];
            $edit_data['role'] = $user['role'];


    }
}

if(isset($_GET['errors'])){
    $errors = json_decode($_GET["errors"], true);
}
$rooms = $database->select("rooms")

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Update your data</h1>
    <form action="../handlers/update_user_handler.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label"> Name</label>
            <input type="text" name="username" class="form-control" id="username"
                   value="<?php echo isset($edit_data['username']) ? $edit_data['username'] : ''; ?>"
            >
            <?php if(isset($errors['username'])): ?>
                <div class="text-danger"><?php echo $errors['name']; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email"
                   value="<?php echo isset($edit_data['email']) ? $edit_data['email'] : ''; ?>"
            >
            <?php if(isset($errors['email'])): ?>
                <div class="text-danger"><?php echo $errors['email']; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password"
                   value="<?php echo isset($edit_data['password']) ? $edit_data['password'] : ''; ?>"
            >
            <?php if(isset($errors['password'])): ?>
                <div class="text-danger"><?php echo $errors['password']; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"
                   value="<?php echo isset($edit_data['confirmPassword']) ? $edit_data['confirmPassword'] : ''; ?>"
            >
            <?php if(isset($errors['confirmPassword'])): ?>
                <div class="text-danger"><?php echo $errors['confirmPassword']; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="room_id" class="form-label">Room No</label>
            <select name="room_id" class="form-select" id="room_id">
                <?php foreach ($rooms as $room): ?>
                    <option value="<?php echo $room['id']; ?>" <?php echo (isset($edit_data['room_id']) && $edit_data['room_id'] == $room['id']) ? 'selected' : ''; ?>><?php echo $room['room_number']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php if(isset($errors['room_id'])): ?>
                <div class="text-danger"><?php echo $errors['room_id']; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
    <label class="form-label">Role</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="role" id="userRole" value="user" <?php echo (isset($edit_data['role']) && $edit_data['role'] === 'user') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="userRole">
            User
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="role" id="adminRole" value="admin" <?php echo (isset($edit_data['role']) && $edit_data['role'] === 'admin') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="adminRole">
            Admin
        </label>
    </div>
    <?php if(isset($errors['role'])): ?>
        <div class="text-danger"><?php echo $errors['role']; ?></div>
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
