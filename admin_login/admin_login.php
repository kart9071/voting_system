<?php
session_start();

// Function to validate login credentials
function validateLogin($username, $password) {
    $users = array_map('str_getcsv', file('admin_credentials.csv')); // Load users from CSV file
    foreach ($users as $user) {
        if ($user[0] === $username && password_verify($password, $user[1])) {
            return true; // Valid credentials
        }
    }
    return false; // Invalid credentials
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (validateLogin($username, $password)) {
        // If login is successful, redirect to admin page
        $_SESSION['username'] = $username;
        header('Location: admin.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if(isset($error)) echo "<p>$error</p>"; ?>
    <form method="post" action="">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
