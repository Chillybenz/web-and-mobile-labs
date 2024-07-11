-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 11 Ιουλ 2024 στις 14:09:07
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `ds_estate`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `listings`
--

CREATE TABLE `listings` (
  `id` int(6) UNSIGNED NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `num_rooms` int(11) NOT NULL,
  `price_per_night` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `listings`
--

INSERT INTO `listings` (`id`, `image`, `title`, `area`, `num_rooms`, `price_per_night`) VALUES
(1, 'images/home1.jpg', 'Alimos', 'Attiki', 3, 150),
(2, 'images/home1.jpg', 'Faliros', 'Peiraias', 5, 400),
(3, 'images/home3.jpg', 'Glyfada Spiti', 'Glyfada', 4, 350);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `reservations`
--

CREATE TABLE `reservations` (
  `id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL,
  `listing_id` int(6) UNSIGNED NOT NULL,
  `start_reservation` date NOT NULL,
  `end_reservation` date NOT NULL,
  `name_reservation` varchar(15) NOT NULL,
  `surname_reservation` varchar(15) NOT NULL,
  `email_reservation` varchar(30) DEFAULT NULL,
  `final_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `listing_id`, `start_reservation`, `end_reservation`, `name_reservation`, `surname_reservation`, `email_reservation`, `final_amount`) VALUES
(1, 1, 1, '2024-06-26', '2024-07-05', 'Aristotle', 'Koinakis', 'taramosalata003@gmail.com', 945),
(2, 1, 1, '2024-06-25', '2024-06-25', 'Aristotle', 'Koinakis', 'taramosalata003@gmail.com', NULL),
(3, 1, 1, '2024-08-31', '2024-09-25', 'Aristotle', 'Koinakis', 'taramosalata003@gmail.com', 2963);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `fname` varchar(15) NOT NULL,
  `surname` varchar(15) NOT NULL,
  `username` varchar(24) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `fname`, `surname`, `username`, `password`, `email`) VALUES
(1, 'Aristotle', 'Koinakis', 'Aris003', 'ma130241', 'taramosalata003@gmail.com');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `listings`
--
ALTER TABLE `listings`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT για πίνακα `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
