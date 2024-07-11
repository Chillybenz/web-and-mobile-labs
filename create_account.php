<meta name="viewport" content="width=device-width, initial-scale=1.0"><!--Needed for mobile view-->
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css"><!--reference to css file-->
        <script src="validation.js"></script><!--reference to js file-->
        </head>
    </head>
    <body>
        <header class="navbar">
            <button class="burger" onclick="myFunction()"><!--calls function from the validation.js-->
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </button>
            <div id="nav-links" class="nav-links">
                <div>
                    <?php if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true): ?><!--checks if user is connected-->
                        <a href="logout.php">Sign Out</a>
                    <?php else: ?>
                        <a href="login.php">Sign In</a>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true): ?><!--checks if user is connected-->
                        <a href="CreateListing.php">Create Listing</a>
                    <?php else: ?>
                        <a href="create_account.php">Create Account</a>
                    <?php endif; ?>
                </div>
                <div>
                    <a href="Feed.php">Feed</a>
                </div>
            </div>
        </header>
        <h1>Create Account</h1>
        <form id="createAccountForm" action="create_account.php" method="POST"><!--form for creating account with necessary required checks-->
            Name <input type="text" name="name" pattern="[A-Za-z]+" required> <br>
            Surname <input type="text" name="surname" pattern="[A-Za-z]+" required> <br>
            Username <input type="text" name="username" required> <br>
            Password <input type="password" name="password" pattern="(?=.*\d).{4,10}" required> <br>
            Email <input type="email" name="email" required> <br>
            <input type="submit" value="Submit">
        </form>
   
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {//gets response
            // Retrieve form data
            $firstname = $_POST['name'];
            $surname = $_POST['surname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
        
            //Name and surname must contain only characters
            if (!preg_match("/^[a-zA-Z]+$/", $firstname)) {
                die("Name must contain only characters.");
            }
            if (!preg_match("/^[a-zA-Z]+$/", $surname)) {
                die("Surname must contain only characters.");
            }
        
            // Password must contain at least one number and be between 4 and 10 characters.
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
        
                // Create new user
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
                echo "New account created successfully";
        
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        ?>
        <footer>
            <div class = "contact">
                <p>Contact us: <a href="tel:12345678">+1234567</a> | <a href="aristotlekoin@gmail.com">aristotlekoin@gmail.com</a></p>
            </div>

            <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3147.8213474764925!2d23.743311199999997!3d37.9112383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bdbe5d00b7fd%3A0xae17e26842a6294f!2zR0FNSU5HIEdBTEFYWSDOlc6czqDOn86hzpnOms6XIM6VLs6VLg!5e0!3m2!1sel!2sgr!4v1718322586862!5m2!1sel!2sgr" width="150" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </footer>
    </body> 
</html>