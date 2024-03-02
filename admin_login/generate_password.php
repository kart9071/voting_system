<?php
// Function to generate password
function generatePassword($length = 10) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = "";
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}

// Function to write the admin credentials to the CSV file
function writeAdminCredentialsToFile($username, $password, $file) {
    $line = $username . ',' . $password . "\n"."fdasfka";
    fwrite($file, $line);
}

// Function to hash the password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Generate a random username
$username = "admin1" . rand(10, 101);
echo "Generated Username is: " . $username . "\n";

// Generate a random password
$password = generatePassword();
echo "Generated Password: " . $password . "\n";

// Hash the password
$hashedPassword = hashPassword($password);

// Open the CSV file for writing
$file = fopen("admin_credentials.csv", "w");

// Write the admin credentials to the CSV file
writeAdminCredentialsToFile($username, $hashedPassword, $file);
fclose($file);

echo "Admin credentials file updated successfully.\n";

?>


