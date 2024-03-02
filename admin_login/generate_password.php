<?php
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    $line = $username . ',' . $password . "\n";
    fwrite($file, $line);
}

// Function to hash the password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to send email using SMTP
function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'karthikshetty200313@gmail.com'; // Your Gmail address
        $mail->Password = 'Hello@887'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email headers
        $mail->setFrom('karthikshetty200313@gmail.com', 'Karthik Shetty'); // Replace with your name
        $mail->addAddress($to);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
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

// Send the generated credentials to your email
$to = "karthikshetty200313@gmail.com"; // Replace with your mobile's email to SMS gateway
$subject = "Hello".$username."Thank you for the login"."\n"."Please refer this email message for the admin credentials details of your application";
$message = "Username: $username \n Password: $password";
if (sendEmail($to, $subject, $message)) {
    echo "Credentials sent to your mobile successfully.\n";
} else {
    echo "Failed to send credentials to your mobile.\n";
}

?>


