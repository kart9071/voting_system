<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database="voting_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";


// $conn->close();
?>
