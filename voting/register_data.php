<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include "includes/all-select-data.php";
$count = mysqli_num_rows($voter_data);

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$idname = $_POST['idname'];
$idnum = $_POST['idnum'];
$instidnum = $_POST['instidnum'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$address = $_POST['address'];

if (isset($_POST['register'])) {
    $con = mysqli_connect('localhost', 'root', 'root', 'voting');
    $date1 = new DateTime($dob);
    $date2 = new DateTime("now");
    $dateDiff = $date1->diff($date2);

    if (strlen($phone) != 10) {
        echo "<script> 
                alert('Phone Number must be 10 digits');
                history.back();
              </script>";
    } else if (!is_numeric($phone)) {
        echo "<script> 
                alert('Phone Number must be numeric');
                history.back();
              </script>";
    } else if (strlen($idnum) > 13) {
        echo "<script> 
                alert('Enter a valid ID number');
                history.back();
              </script>";
    } else if ($dateDiff->days < 6570) {
        echo "<script>
                alert('Your age must be above 18 years');
                history.back();
              </script>";
    } else {
        $filename = $_FILES["idcard"]["name"];
        $tempname = $_FILES["idcard"]["tmp_name"];
        $folder = "img/" . $count . $filename;

        if (move_uploaded_file($tempname, $folder)) {
            $stmt = $con->prepare("INSERT INTO register (fname, lname, idname, idnum, idcard, inst_id, dob, gender, phone, address,verify, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,'No','not voted')");
            $stmt->bind_param("ssssssssss", $fname, $lname, $idname, $idnum, $folder, $instidnum, $dob, $gender, $phone, $address);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Registration Successfully!');
                        location.href='index.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Mobile number or ID Number already exists!');
                        history.back();
                      </script>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<script>
                    alert('Failed to upload ID card');
                    history.back();
                  </script>";
        }
    }

    // Close the connection
    $con->close();
}

?>
