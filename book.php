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
    <h2>Book</h2>
    <div id="bookings">
        <?php
            if (isset($_GET['id'])) {
                $listing_id = $_GET['id'];
                // Create PDO connection
                $servername = "mysql:host=localhost;dbname=ds_estate";
                $db_username = "root";
                $db_password = "";
                try {
                    $conn = new PDO($servername, $db_username, $db_password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // Prepare and execute query to fetch listing details
                    $stmt = $conn->prepare("SELECT id, image, title, area, num_rooms, price_per_night FROM Listings WHERE id = :id");
                    $stmt->bindParam(':id', $listing_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $listing = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($listing) {
                        // Display the listing details
                        echo "<div class='listing-book'>";
                        echo "<img class='booking-image' src='" . htmlspecialchars($listing['image']) . "' alt='Listing Image'>";
                        echo "<h3>" . htmlspecialchars($listing['title']) . "</h3>";
                        echo "<p>Περιοχή: " . htmlspecialchars($listing['area']) . "</p>";
                        echo "<p>Πλήθος δωματίων: " . htmlspecialchars($listing['num_rooms']) . "</p>";
                        echo "<p>Τιμή ανά διανυκτέρευση: " . htmlspecialchars($listing['price_per_night']) . "€</p>";
                        echo "</div>";
                    } else {
                        echo "No listing found with ID " . htmlspecialchars($listing_id);
                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
            } else {
                echo "No listing ID provided.";
            }
        ?>

        <?php
            $showDateForm = true;
            $errorMessage = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_dates'])) {
                $start_date = $_POST['start_date'];
                $ending_date = $_POST['ending_date'];
                // Check if the reservation dates are available
                try {
                    $stmt = $conn->prepare("SELECT * FROM Reservations WHERE listing_id = :listing_id AND (start_reservation <= :ending_date AND end_reservation >= :start_date)");
                    $stmt->bindParam(':listing_id', $listing_id);
                    $stmt->bindParam(':start_date', $start_date);
                    $stmt->bindParam(':ending_date', $ending_date);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $errorMessage = "The house is booked on these dates.";
                    } else {
                        $startDate = new DateTime($start_date);
                        $endDate = new DateTime($ending_date);
                        $interval = $startDate->diff($endDate);
                        $nights = $interval->days;
                        if ($nights <= 0) {
                            $errorMessage = "Invalid date range.";
                        } else {
                            $initial_amount = $nights * $listing['price_per_night'];
                            $discount_percentage = rand(10, 30) / 100;
                            $final_amount = $initial_amount - ($initial_amount * $discount_percentage);

                            echo "<h3>The rooms are available.</h3>";
                            echo "<div class='final-step'>";
                            echo "<form id='finalBookingForm' action='' method='POST'>";
                            echo "<strong>Name:</strong> <input type='text' name='name_reservation' value='" . htmlspecialchars($_COOKIE['name']) . "' required><br><br>";
                            echo "<strong>Surname:</strong> <input type='text' name='surname_reservation' value='" . htmlspecialchars($_COOKIE['surname']) . "' required><br><br>";
                            echo "<strong>Email:</strong> <input type='email' name='email_reservation' value='" . htmlspecialchars($_COOKIE['email']) . "' required><br><br>";
                            echo "<input type='hidden' name='start_date' value='" . htmlspecialchars($start_date) . "'>";
                            echo "<input type='hidden' name='ending_date' value='" . htmlspecialchars($ending_date) . "'>";
                            echo "<strong>Final amount:</strong> $final_amount €<br>";
                            echo "<input type='hidden' name='final_amount' value='" . htmlspecialchars($final_amount) . "'>";
                            echo "<input type='submit' name='confirm_booking' value='Confirm Booking'>";
                            echo "</form>";                        
                            echo "</div>";

                            $showDateForm = false;
                        }
                    }
                } catch (PDOException $e) {
                    $errorMessage = "Error: " . $e->getMessage();
                }
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_booking'])) {
                $start_date = $_POST['start_date'];
                $ending_date = $_POST['ending_date'];
                $name_reservation = $_POST['name_reservation'];
                $surname_reservation = $_POST['surname_reservation'];
                $email_reservation = $_POST['email_reservation'];
                $final_amount = $_POST['final_amount'];
                // Retrieve user_id from session or cookie
                $Cook_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : null; // Check if the user_id is set in a cookie

                if ($Cook_id) {
                    try {
                        $startDate = new DateTime($start_date);
                        $endDate = new DateTime($ending_date);
                        // Convert DateTime objects to string
                        $startDateStr = $startDate->format('Y-m-d');
                        $endDateStr = $endDate->format('Y-m-d');

                        // Insert the reservation
                        $sql = "INSERT INTO Reservations (user_id, listing_id, start_reservation, end_reservation, name_reservation, surname_reservation, email_reservation, final_amount) 
                                VALUES (:user_id, :listing_id, :startDate, :endingDate, :name_reservation, :surname_reservation, :email_reservation, :final_amount)";
                        $stmt = $conn->prepare($sql);
                        // Bind parameters
                        $stmt->bindParam(':user_id', $Cook_id);
                        $stmt->bindParam(':listing_id', $listing_id);
                        $stmt->bindParam(':startDate', $startDateStr);
                        $stmt->bindParam(':endingDate', $endDateStr);
                        $stmt->bindParam(':name_reservation', $name_reservation);
                        $stmt->bindParam(':surname_reservation', $surname_reservation);
                        $stmt->bindParam(':email_reservation', $email_reservation);
                        $stmt->bindParam(':final_amount', $final_amount);
                        // Execute statement
                        $stmt->execute();
                        echo "New reservation created successfully";
                        $showDateForm = false;
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                } else {
                    echo "User ID not found. Please log in.";
                }
            }

            if ($showDateForm) {
                if (!empty($errorMessage)) {
                    echo "<p class='error-message'>$errorMessage</p>";
                }
                echo '<form id="bookingForm" action="" method="POST">
                       <strong>Enter starting date:</strong> <input type="date" id="start_date" name="start_date" required><br><br>
                       <strong>Enter ending date:</strong> <input type="date" id="ending_date" name="ending_date" required><br><br>
                       <input type="submit" name="check_dates" value="Date Check">
                      </form>';
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
            