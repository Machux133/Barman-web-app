-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 05:17 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bar`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `available_ingredients`
--

CREATE TABLE `available_ingredients` (
  `id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `available_ingredients`
--

INSERT INTO `available_ingredients` (`id`, `ingredient_id`) VALUES
(43, 13),
(42, 14),
(41, 18),
(40, 20),
(39, 21);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cocktails`
--

CREATE TABLE `cocktails` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `ingredients` varchar(400) NOT NULL,
  `recipe` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `cocktails`
--

INSERT INTO `cocktails` (`id`, `name`, `ingredients`, `recipe`) VALUES
(1, 'Mojito', '3,7,8,9', 'Muddle mint leaves with sugar syrup, add rum and lime juice, fill glass with soda water and ice.'),
(2, 'Margarita', '4,5,6', 'Shake tequila, triple sec, and lime juice with ice, strain into a glass.'),
(7, 'Cosmopolitan', '13,17,18', 'Shake vodka, triple sec, and lime juice with ice, strain into a glass.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`) VALUES
(13, 'Vodka'),
(14, 'Gin'),
(15, 'Rum'),
(16, 'Tequila'),
(17, 'Triple Sec'),
(18, 'Lime Juice'),
(19, 'Sugar Syrup'),
(20, 'Mint Leaves'),
(21, 'Soda Water');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `available_ingredients`
--
ALTER TABLE `available_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Indeksy dla tabeli `cocktails`
--
ALTER TABLE `cocktails`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `available_ingredients`
--
ALTER TABLE `available_ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `cocktails`
--
ALTER TABLE `cocktails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `available_ingredients`
--
ALTER TABLE `available_ingredients`
  ADD CONSTRAINT `available_ingredients_ibfk_1` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
