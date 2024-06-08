<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        Username: <input type="text" name="username" required> <br>
        Password: <input type="password" name="password" required> <br>
        <input type="submit" value="Login">
    </form>
   
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Create PDO connection
        $servername = "mysql:host=localhost;dbname=ds_estate";
        $db_username = "root";
        $db_password = "";
        try {
            $conn = new PDO($servername, $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Check if username and password match
            $stmt = $conn->prepare("SELECT * FROM Users WHERE username = :username AND password = :password");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                echo "Login successful!";
            } else {
                echo "Invalid username or password.";
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
