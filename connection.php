<html><?php 
    // Creating connection to MySQL server
    $conn = new mysqli("localhost", "root", "");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create Database
    $sql_create_db = "CREATE DATABASE IF NOT EXISTS ds_estate";
    if ($conn->query($sql_create_db) === TRUE) {
        echo "Database created successfully<br>";
    } else {
        echo "Error creating database: " . $conn->error . "<br>";
    }

    // Select database
    $conn->select_db("ds_estate");

    // Query to create table
    $sql_table = "CREATE TABLE IF NOT EXISTS Users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        fname VARCHAR(15) NOT NULL,
        surname VARCHAR(15) NOT NULL,
        username VARCHAR(24),
        password VARCHAR(30),
        email VARCHAR(30)
    )";

    // Check for creation of table
    if ($conn->query($sql_table) === TRUE) {
        echo "Table Users created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }

    // Close MySQLi connection
    $conn->close();
?>
</html>