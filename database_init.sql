-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 05. čen 2022, 23:49
-- Verze serveru: 10.4.24-MariaDB
-- Verze PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `sneaker_eshop`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `state` enum('accepted','processing','sent') NOT NULL DEFAULT 'accepted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `invoices_sneakers`
--

CREATE TABLE `invoices_sneakers` (
  `id` int(11) NOT NULL,
  `idinvoice` int(11) NOT NULL,
  `idsneaker` int(11) NOT NULL,
  `size` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `sneakers`
--

CREATE TABLE `sneakers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `price` int(5) NOT NULL,
  `imgpath` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `sneakers`
--

INSERT INTO `sneakers` (`id`, `name`, `description`, `price`, `imgpath`) VALUES
(1, 'Retro High Dark Mocha', 'Jordan 1 High Mocha je zcela určitě teniska roku 2020. Tyhle jedničky mají color-blocking jako legendární Black Toes. Jejich barevné provedení připomíná nejúspěšnější kolaboraci s Travisem Scottem. ', 10999, 'retro-high-dark-mocha.jpg'),
(2, 'Retro High White University Blue', '', 3999, 'retro-high-white-university-blue-black.jpg'),
(3, 'Retro High Tie Dye', '', 4499, 'retro-high-tie-dye-ps.jpg'),
(4, 'High Zoom Air CMFT Pumpkin Spice', '', 5999, 'high-zoom-air-cmft-pumpkin-spice.jpg'),
(5, 'Retro High OG Dark Marina Blue', '', 6999, 'retro-high-og-dark-marina-blue.jpg'),
(6, 'Mid Black Particle Grey', '', 3499, 'mid-black-particle-grey.jpg'),
(7, 'Retro High Turbo Green', '', 18999, 'retro-high-turbo-green.jpg'),
(8, 'Retro High Travis Scott', '', 67999, 'retro-high-travis-scott.jpg'),
(9, 'Retro High OG Brotherhood', '', 6499, 'retro-high-og-brotherhood-1-1000.jpg'),
(10, 'Retro High COJP Midnight Navy', 'Jordan 1 CO.JP Midnight Navy patří mezi tenisky vytvořené díky CO.JP (Concept Japan), což byla podznačka Nike v devadesátkách.  CO.JP vytvářeli produkty pouze pro japonský market. Nikde jinde tyto tenisky nevycházely, a ještě k tomu vycházely v extrémně limitovaném množství, například tento pár vyšel v roce 2001 a vyšlo pouze 2001 párů.', 9999, 'retro_high_cojp_midnight_navy.jpg');

-- --------------------------------------------------------

--
-- Struktura tabulky `sneakersizes`
--

CREATE TABLE `sneakersizes` (
  `id` int(11) NOT NULL,
  `sneakerid` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `sneakersizes`
--

INSERT INTO `sneakersizes` (`id`, `sneakerid`, `size`, `amount`) VALUES
(1, 6, 42, 9),
(2, 6, 43, 1),
(3, 6, 45, 8),
(5, 8, 45, 4),
(6, 9, 43, 6),
(7, 6, 47, 18),
(8, 10, 42, 10),
(9, 1, 47, 25);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` int(9) NOT NULL,
  `street` varchar(100) NOT NULL,
  `propertynum` int(8) NOT NULL,
  `city` varchar(70) NOT NULL,
  `postcode` int(5) NOT NULL,
  `isadmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`userid`);

--
-- Indexy pro tabulku `invoices_sneakers`
--
ALTER TABLE `invoices_sneakers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idinvoice` (`idinvoice`),
  ADD KEY `idsneaker` (`idsneaker`);

--
-- Indexy pro tabulku `sneakers`
--
ALTER TABLE `sneakers`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `sneakersizes`
--
ALTER TABLE `sneakersizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `size` (`size`),
  ADD KEY `sneakerid` (`sneakerid`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phonenumber` (`phonenumber`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `invoices_sneakers`
--
ALTER TABLE `invoices_sneakers`
  ADD CONSTRAINT `invoices_sneakers_ibfk_1` FOREIGN KEY (`idinvoice`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_sneakers_ibfk_2` FOREIGN KEY (`idsneaker`) REFERENCES `sneakers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `sneakersizes`
--
ALTER TABLE `sneakersizes`
  ADD CONSTRAINT `sneakersizes_ibfk_1` FOREIGN KEY (`sneakerid`) REFERENCES `sneakers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
