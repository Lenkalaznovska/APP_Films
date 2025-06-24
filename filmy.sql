-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 30. kvě 2024, 23:26
-- Verze serveru: 10.4.32-MariaDB
-- Verze PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `filmy`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `filmy`
--

CREATE TABLE `filmy` (
  `Id` int(11) NOT NULL,
  `Název filmu` varchar(255) NOT NULL,
  `Autor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `filmy`
--

INSERT INTO `filmy` (`Id`, `Název filmu`, `Autor`) VALUES
(1, 'Matrix', 'Lilly Wachowski'),
(50, 'Ferrari', 'Michael Mann'),
(58, 'Harry Potter', 'J. K. Rowling'),
(74, 'Wonka', 'Paul King');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `filmy`
--
ALTER TABLE `filmy`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `filmy`
--
ALTER TABLE `filmy`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
