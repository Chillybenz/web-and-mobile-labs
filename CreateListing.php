<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="validation.js"></script>
    </head>
    <body>
        <header class="navbar">
            <button class="burger" onclick="myFunction()">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></di>
            </button>
            <div id="nav-links" class="nav-links">
                <div>
                    <?php if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true): ?>
                        <a href="logout.php">Sign Out</a>
                    <?php else: ?>
                        <a href="login.php">Sign In</a>
                    <?php endif; ?>
                </div>
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
        <h2>Create Listing</h2>
        <form name="createListingForm" action="CreateListing.php" method="POST" enctype = "multipart/form-data">
            <label for="image" >Insert a photo of the property:</label>
            <input type = "file" name = "image" accept="image/png, image/jpeg, image/jpg" required> <br>
            <label for = "title">Insert Title:</label>
            <input type="text" name="title" id="title" required><br>
            <label for="area">Insert area:</label>
            <input type="text" name="area" id="area" required><br>
        
            <label for="num_rooms">Insert number of rooms:</label>
            <input type="number" name="num_rooms" id="num_rooms" required><br>
        
            <label for="price_per_night">Insert price per night:</label>
            <input type="number" name="price_per_night" id="price_per_night" required><br>
        
            <input type="submit" value="Create Listing">
        </form>

        <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Retrieve form data
                $title = $_POST['title'];
                $area = $_POST['area'];
                $num_rooms = intval($_POST['num_rooms']);
                $price_per_night = intval($_POST['price_per_night']);
                // File upload handling
                if (!empty($_FILES['image']['tmp_name'])) {
                    $image = $_FILES['image']['tmp_name'];
                    $target_dir = 'images/';
                    $target_file = $target_dir . basename($_FILES['image']['name']);
            
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($image, $target_file)) {
                        $image_url = $target_file;
                        echo "Image uploaded successfully.";
                    } else {
                        echo "Failed to upload image.";
                    }
                } else {
                    echo "Image not set.";
                }

                if (!preg_match("/^[a-zA-Z\s]+$/", $title)) {
                    die("Title must contain only characters.");
                }
                if (!preg_match("/^[a-zA-Z\s]+$/", $area)) {
                    die("Area must contain only characters.");
                }
                if ($num_rooms<=0) {
                    die("The number of rooms must be a positive integer.");
                }
                if ($price_per_night<=0) {
                    die("The price per night must be a positive integer.");
                }


                    // Create PDO connection
                $servername = "mysql:host=localhost;dbname=ds_estate";
                $db_username = "root";
                $db_password = "";
        
                try {
                    $conn = new PDO($servername, $db_username, $db_password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                    // Insert new listing into the database
                    $sql = "INSERT INTO Listings (image, title, area, num_rooms, price_per_night) 
                        VALUES (:image, :title, :area, :num_rooms, :price_per_night)";
                    $stmt = $conn->prepare($sql);
        
                    // Bind parameters
                    $stmt->bindParam(':image', $image_url);
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':area', $area);
                    $stmt->bindParam(':num_rooms', $num_rooms);
                    $stmt->bindParam(':price_per_night', $price_per_night);
        
                    // Execute statement
                    $stmt->execute();
                    echo "New listing created successfully";
        
                }catch (PDOException $e) {
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