<?php
require '../database_management/connector.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $age = $_POST['age'];
    $address = $_POST['address'];

    // Check if email already exists
    $check_email_stmt = $conn->prepare("SELECT id FROM voters WHERE email = ?");
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $check_email_stmt->store_result();
    if($check_email_stmt->num_rows > 0){
        $error = "Email already exists";
    }
    $check_email_stmt->close();

    // Check if name already exists
    $check_name_stmt = $conn->prepare("SELECT id FROM voters WHERE name = ?");
    $check_name_stmt->bind_param("s", $name);
    $check_name_stmt->execute();
    $check_name_stmt->store_result();
    if($check_name_stmt->num_rows > 0){
        $error = "Name already exists";
    }
    $check_name_stmt->close();

    // If email and name are unique, proceed with registration
    if(!isset($error)) {
        //Executing the SQL Statements 
        $stmt=$conn->prepare("INSERT INTO voters (name, email, age, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis",$name,$email,$age,$address);
        if($stmt->execute()){
            $message="Registration successful";
        }
        else{
            $error="Error:".$stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Voters Registration</h2>
    <?php if(isset($message)) echo "<p>$message</p>"; ?>
    <?php if(isset($error)) echo "<p>$error</p>"; ?>
    <form method="post" action="">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="age">Age:</label><br>
        <input type="number" id="age" name="age" required><br>
        <label for="address">Address:</label><br>
        <textarea id="address" name="address" rows="4" cols="50" required></textarea><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
