<meta name="viewport" content="width=device-width, initial-scale=1.0"><!--Needed for mobile view-->
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css"><!--reference to css file-->
        <script src="validation.js"></script><!--reference to js file-->
    </head>
    <body>
        <header class="navbar">
            <button class="burger" onclick="myFunction()"><!--calls function from the validation.js-->
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></di>
            </button>
            <div id="nav-links" class="nav-links">
            <!--checks if user is connected-->
                <div>
                    <?php if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true): ?>
                        <a href="logout.php">Sign Out</a>
                    <?php else: ?>
                        <a href="login.php">Sign In</a>
                    <?php endif; ?>
                </div>
            <!--checks if user is connected-->
                <div>
                    <?php if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true): ?>
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
        <h1>Sign in</h1>
        <!--form for logging in-->
        <form class="login-form" action="" method="POST">
            Username <input type="text" name="username" required><br>
            Password <input type="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {//gets response
                // Retrieve form data
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Create PDO connection
                $servername = "mysql:host=localhost;dbname=ds_estate";
                $db_username = "root";
                $db_password = "";

                try {
                    $conn = new PDO($servername, $db_username, $db_password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Check if username and password are correct
                    $stmt = $conn->prepare("SELECT * FROM Users WHERE BINARY username = :username AND password = :password");
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->execute();

                    if ($stmt->rowCount() == 1) {
                        // Fetch user details
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        // Set cookies with user informatio that expire in 30 days
                        setcookie('username', $user['username'], time() + (86400 * 30), "/");
                        setcookie('id', $user['id'], time() + (86400 * 30), "/");
                        setcookie('name', $user['fname'], time() + (86400 * 30), "/");
                        setcookie('surname', $user['surname'], time() + (86400 * 30), "/");
                        setcookie('email', $user['email'], time() + (86400 * 30), "/");
                        setcookie('logged_in', true, time() + (86400 * 30), "/");
                        echo($user['id']);
                        // Redirect to a new page or perform other actions
                        header("Location: feed.php");
                        exit();
                    } else {
                        echo "Invalid Username or Password.";
                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
            }
        ?>

        <footer>
            <div class="contact">
                <p>Contact us: <a href="tel:12345678">+1234567</a> | <a href="aristotlekoin@gmail.com">aristotlekoin@gmail.com</a></p>
            </div>

            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3147.8213474764925!2d23.743311199999997!3d37.9112383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bdbe5d00b7fd%3A0xae17e26842a6294f!2zR0FNSU5HIEdBTEFYWSDOlc6czqDOn86hzpnOms6XIM6VLs6VLg!5e0!3m2!1sel!2sgr!4v1718322586862!5m2!1sel!2sgr" width="150" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </footer>
    </body>
</html>
