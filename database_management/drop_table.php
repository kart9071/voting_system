<!-- for dropping of the table -->

<?php
// Check if tables exist
require 'connector.php';
$tables_exist = false;
$result = $conn->query("SHOW TABLES LIKE 'voters'");
if ($result->num_rows > 0) {
    $tables_exist = true;
}

if($tables_exist){
    $drop_sql="DROP TABLE IF EXISTS voters,candidates,admins;";
    if($conn->multi_query($drop_sql)==TRUE){
            echo "Tables dropped successfully"."<br>";
    }
    else{
        echo "There is an problem in dropping the table: " . $conn->error."<br>";
    }
}
?>