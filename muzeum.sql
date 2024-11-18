-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Kwi 2023, 18:45
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `muzeum`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `goscie`
--

CREATE TABLE `goscie` (
  `goscie_id` int(11) NOT NULL,
  `ile` smallint(6) NOT NULL,
  `kiedy` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `goscie`
--

INSERT INTO `goscie` (`goscie_id`, `ile`, `kiedy`) VALUES
(17, 5, '2023-04-21');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `typ` varchar(50) NOT NULL,
  `cena` decimal(8,2) NOT NULL,
  `od` decimal(2,0) DEFAULT NULL,
  `do` decimal(2,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `ticket`
--

INSERT INTO `ticket` (`id`, `typ`, `cena`, `od`, `do`) VALUES
(1, 'Zwiedzanie samodzielne', '5.00', '1', '10'),
(2, 'Audioprzewodnik', '8.00', '1', '5'),
(3, 'Przewodnik', '15.00', '1', '9'),
(9, 'Przewodnik grupowy', '13.00', '10', '25');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `pass` text NOT NULL,
  `email` text NOT NULL,
  `imie` varchar(50) DEFAULT NULL,
  `nazwisko` varchar(50) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `saldo` decimal(8,2) DEFAULT NULL,
  `pracownik` tinyint(1) DEFAULT NULL,
  `ban` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `pass`, `email`, `imie`, `nazwisko`, `admin`, `saldo`, `pracownik`, `ban`) VALUES
(22, '$2y$10$N638mSnQwk8TPOmeZFjaJuSGJh0sjNQ.VAOAodF3YrELgSB2FuKEK', 'User@gmail.com', 'Pan', 'User', 0, '570.00', 0, 0),
(15, '$2y$10$ITZQlvNgGoRrq02FRhZCOO7NIxeSq1soRZJoamupRpqkcA3X1n/SG', 'Admin@gmail.com', 'Pan', 'Admin', 1, '0.00', 0, 0),
(16, '$2y$10$PSqaWaDr72pI4CoIXqTpuO5v6ecMQxelBfvzW4Bj66T5afqwabVDa', 'Pracownik@gmail.com', 'Pan', 'Pracownik', 0, '0.00', 1, 0),
(21, '$2y$10$EIjwvFC4EWC.EKIiV/8g1OHwkHiI8myquGB8XBnvmJBrAOayfGwWC', 'Ban@gmail.com', 'Pan', 'Zbanowany', 0, '0.00', 0, 1),
(25, '$2y$10$jtN4UhYX56HRw5nAaAwOZu67NHzwnViiUGAQrP0yHsbFQk.QpwG9q', 'Patrykkotula@gmail.com', 'Patryk', 'Kotula', 2, '0.00', 0, 0),
(26, '$2y$10$tfiqM8YlOl.pqJ7kuMFKf.zvc15yAMEWnw.iM22IwQaHMRm/FFf3u', 'Czarnym@gmail.com', 'Mateusz', 'Czarnojan', 0, '0.00', 0, 0),
(27, '$2y$10$aSjBYcR4Wu7Ai1jj5NOQjOcHgF6VEELX3OWJ7Fif/K9VS.5okKrie', 'Jank@gmail.com', 'Jan', 'Kowalski', 0, '0.00', 0, 0),
(28, '$2y$10$hqXEXNl6aTeTOBMzRKi0l.aQKwqjbRDkNJnmyPFz4Z8U7sHoVk65C', 'Adamk@gmail.com', 'Adam', 'Kozak', 0, '0.00', 0, 0),
(29, '$2y$10$jxpRAV4WTnjDr7a8vnIfzu6Gbgzck83usb8yjBXC3ojRTZZ72ZAdW', 'Jasg@gmail.com', 'Jas', 'Gren', 0, '0.00', 0, 0),
(30, '$2y$10$Ii0tllufV9p0.wHIM2dMnufS2Wpz3HpXJVk3VhhLgQwlrqZy4cSHW', 'Szarzej@gmail.com', 'Andrzej', 'Szary', 0, '0.00', 0, 0),
(31, '$2y$10$0HWj5uYFfAuSkKiupvtYYuXnBzNlDHjOrqwAU9Cxud0LNflfdivn2', 'Sami@gmail.com', 'Milena', 'Sampolska', 0, '0.00', 0, 0),
(32, '$2y$10$lCCzDV7ZInGz6Jc6T8Wg0euHcQ31uJLouxdTVztUg2DC6ptjLwoPK', 'Czarodziej@gmail.com', 'Gandalf', 'Szary', 0, '0.00', 0, 0),
(33, '$2y$10$5CuDmE6D38uoiUJ6OnTdQOi.4E26xTo6ta4U/IHRPCGlqtnSgYPwO', 'Ironman@gmail.com', 'Tony', 'Stark', 0, '0.00', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zakup`
--

CREATE TABLE `zakup` (
  `zakup_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `ilosc` decimal(2,0) NOT NULL,
  `data_zakupu` date NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `kod` decimal(6,0) NOT NULL,
  `cena_b` decimal(2,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `zakup`
--

INSERT INTO `zakup` (`zakup_id`, `data`, `ilosc`, `data_zakupu`, `user_id`, `ticket_id`, `kod`, `cena_b`) VALUES
(130, '2023-11-01', '11', '2023-04-13', 22, 9, '527395', '13'),
(131, '2023-09-01', '4', '2023-04-13', 22, 2, '424825', '8'),
(132, '2023-04-23', '3', '2023-04-21', 22, 1, '615072', '5'),
(133, '2023-10-01', '15', '2023-04-21', 22, 9, '768699', '13'),
(134, '2023-11-01', '4', '2023-04-21', 22, 1, '777923', '5');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `goscie`
--
ALTER TABLE `goscie`
  ADD PRIMARY KEY (`goscie_id`);

--
-- Indeksy dla tabeli `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zakup`
--
ALTER TABLE `zakup`
  ADD PRIMARY KEY (`zakup_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `goscie`
--
ALTER TABLE `goscie`
  MODIFY `goscie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT dla tabeli `zakup`
--
ALTER TABLE `zakup`
  MODIFY `zakup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `zakup`
--
ALTER TABLE `zakup`
  ADD CONSTRAINT `zakup_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
