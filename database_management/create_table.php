<?php
require 'connector.php';
// Check if tables exist
$tables_exist = false;
$result = $conn->query("SHOW TABLES LIKE 'voters'");
if ($result->num_rows > 0) {
    $tables_exist = true;
}

if (!$tables_exist) {
    // Run SQL script to create tables
    $sql_file = "../tables_generator.sql";
    $sql = file_get_contents($sql_file);

    if ($conn->multi_query($sql) === TRUE) {
        echo "Tables created successfully"."<br>";
    } else {
        echo "Error creating tables: " . $conn->error."<br>";
    }
}
$conn->close();
?>