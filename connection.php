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

    $sql_table = "CREATE TABLE IF NOT EXISTS Users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        fname VARCHAR(15) NOT NULL,
        surname VARCHAR(15) NOT NULL,
        username VARCHAR(24),
        password VARCHAR(30),
        email VARCHAR(30)
    )";

    $sql_listings_table = "CREATE TABLE IF NOT EXISTS Listings (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        image VARCHAR(50),
        title VARCHAR(50) NOT NULL,
        area VARCHAR(50) NOT NULL,
        num_rooms INT NOT NULL,
        price_per_night INT NOT NULL
    )";

    $sql_reservations_table = "CREATE TABLE IF NOT EXISTS Reservations (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        user_id INT(6) UNSIGNED NOT NULL,
        listing_id INT(6) UNSIGNED NOT NULL,
        start_reservation DATE NOT NULL,
        end_reservation DATE NOT NULL,
        name_reservation VARCHAR(15) NOT NULL,
        surname_reservation VARCHAR(15) NOT NULL,
        email_reservation VARCHAR(30),
        final_amount INT,
        FOREIGN KEY (user_id) REFERENCES Users(id),
        FOREIGN KEY (listing_id) REFERENCES Listings(id)
    )";

    // Check for the creation of the table
    if ($conn->query($sql_table) === TRUE) {
        echo "Table Users created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
    
    if ($conn->query($sql_listings_table) === TRUE) {
        echo "Table Listings created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }

    // Check for creation of Reservations table
       if ($conn->query($sql_reservations_table) === TRUE) {
        echo "Table Reservations created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
    // Close MySQLi connection
    $conn->close();
?>
</html>