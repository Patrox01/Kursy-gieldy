-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Paź 24, 2024 at 11:54 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usersdb`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `email`) VALUES
(1, 'admin', '$2y$10$NQrhCNY/F3zVSqmqfdRu/.SPIbGw/sVkunQ7Mmq7ZNz4twmEJ2He2', '2024-10-17 10:15:25', 'patrykslomian27@gmail.com'),
(2, 'test', '$2y$10$cQj9kLcEs5Fhjd8h/j.aKOOSTvOuEkw9OcQCh.FovFmRmhUlOMTke', '2024-10-21 11:22:47', 'testtest@gmail.com'),
(3, 'test2', '$2y$10$TDMV3APFbM.iYWsk0uEUgusogJWoVBH/LH86ffh.Gg2DGaF20PZK6', '2024-10-21 11:53:10', 'test2@wp.pl'),
(4, 'test3', '$2y$10$y/M/nG5rsebd6nqwQQiv8OYcks.2d2N/WPh3.tnVbr9p5hxBchr0O', '2024-10-21 11:55:09', 'test3@wp.pl'),
(5, 'testpwned', '$2y$10$WndMjF3aF7EXD.o/Ne5x1uZRbkGDXa7YM87m3JuZ9AcpWz/MiR.Xi', '2024-10-21 12:00:40', 'test@gmail.com'),
(6, 'testpwned2', '$2y$10$Iv7kYQMfZKjlsrf/njXy5.NkOG5RSglxWkP8qA7eql0LVJzKQzq2a', '2024-10-21 12:01:33', 'pwned@gmail.com'),
(7, 'testeter', '$2y$10$O2gM9DXxH5JWRdBti5NVde.KrcE8gQ.tWY327cC5keCG.zIpQ0TD6', '2024-10-21 12:11:19', 'etetet@gmail.com'),
(8, 'admini', '$2y$10$V4Gf7UksZeOLUNlmAMI6yO7PF6zgDoZjmVTBR/xpSnLjNAJHm4p0K', '2024-10-22 12:40:36', 'admini@gmail.com'),
(9, 'Klara1q23', '$2y$10$YIVLBHOUst9ZrznB62oFz.JoClsD26PBa/L/qmjxP1h06mLtjZbdO', '2024-10-22 13:28:21', 'klara@gmail.com');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
