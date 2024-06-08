!DOCTYPE html> 
<html>
    <body>
        <h1>Create Account</h1>
        <form action="create_account.php" method="POST">
            Name: <input type="text" name="name" pattern="[A-Za-z]+" required> <br>
            Surname: <input type="text" name="surname" pattern="[A-Za-z]+" required> <br>
            Username: <input type="text" name="username" required> <br>
            Password: <input type="password" name="password" pattern="(?=.*\d).{4,10}" required> <br>
            Email: <input type="email" name="email" required> <br>
            <input type="submit" value="Submit">
        </form>
   
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $firstname = $_POST['name'];
            $surname = $_POST['surname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
        
            // Validate that name and surname contain only characters
            if (!preg_match("/^[a-zA-Z]+$/", $firstname)) {
                die("Name must contain only characters.");
            }
            if (!preg_match("/^[a-zA-Z]+$/", $surname)) {
                die("Surname must contain only characters.");
            }
        
            // Validate that password length is between 4 and 10 characters and contains at least one number
            if (!preg_match("/(?=.*\d).{4,10}/", $password)) {
                die("Password must be between 4 and 10 characters long and contain at least one number.");
            }
        
            // Create PDO connection
            $servername = "mysql:host=localhost;dbname=ds_estate";
            $db_username = "root";
            $db_password = "";
        
            try {
                $conn = new PDO($servername, $db_username, $db_password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                // Check if username is unique
                $stmt = $conn->prepare("SELECT * FROM Users WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    die("Username already exists. Please choose another username.");
                }
        
                // Check if email is unique
                $stmt = $conn->prepare("SELECT * FROM Users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    die("Email already exists. Please use another email.");
                }
        
                // Insert new user into the database
                $sql = "INSERT INTO Users (fname, surname, username, password, email) 
                        VALUES (:firstname, :surname, :username, :password, :email)";
                $stmt = $conn->prepare($sql);
        
                // Bind parameters
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':surname', $surname);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':email', $email);
        
                // Execute statement
                $stmt->execute();
                echo "New record created successfully";
        
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        ?>
    </body> 
</html>