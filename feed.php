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
        <h2>Feed</h2>
        <div id="listings">
            <?php
                // Create PDO connection
                $servername = "mysql:host=localhost;dbname=ds_estate";
                $db_username = "root";
                $db_password = "";
                try {
                    $conn = new PDO($servername, $db_username, $db_password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                    // Prepare and execute query
                    $stmt = $conn->prepare("SELECT id, image, title, area, num_rooms, price_per_night FROM Listings");
                    $stmt->execute();
                    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($listings) > 0) {
                        // Output data for each row
                        foreach ($listings as $listing) {
                            echo "<div class='listing'>";
                            echo "<img class = 'feed-pic'  src='" . htmlspecialchars($listing['image']) . "' alt='Listing Image'>";
                            echo "<h3>" . htmlspecialchars($listing['title']) . "</h3>";
                            echo "<p>Περιοχή: " . htmlspecialchars($listing['area']) . "</p>";
                            echo "<p>Πλήθος δωματίων: " . htmlspecialchars($listing['num_rooms']) . "</p>";
                            echo "<p>Τιμή ανά διανυκτέρευση: " . htmlspecialchars($listing['price_per_night']) . "€</p>";
                            if  (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true){
                                echo "<button onclick=\"window.location.href='book.php?id=" . htmlspecialchars($listing['id']) . "'\">Κράτηση</button>";
                            } else {
                                echo  "<button onclick=\"window.location.href='login.php?id=" . htmlspecialchars($listing['id']) . "'\">Κράτηση</button>";
                            }
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Δεν υπάρχουν διαθέσιμα ακίνητα.</p>";
                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
            ?>
        </div>

        <footer>
            <div class="contact">
                <p>Contact us: <a href="tel:12345678">+1234567</a> | <a href="mailto:aristotlekoin@gmail.com">aristotlekoin@gmail.com</a></p>
            </div>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3147.8213474764925!2d23.743311199999997!3d37.9112383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bdbe5d00b7fd%3A0xae17e26842a6294f!2zR0FNSU5HIEdBTEFYWSDOlc6czqDOn86hzpnOms6XIM6VLs6VLg!5e0!3m2!1sel!2sgr!4v1718322586862!5m2!1sel!2sgr" width="150" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </footer>
    </body>
</html>