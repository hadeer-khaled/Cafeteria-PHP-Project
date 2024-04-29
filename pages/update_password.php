<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <form action="../handlers/handle_new_password.php" method="post">
        <label for="password">New Password:</label>
        <input type="text" id="password" name="password" required><br><br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
