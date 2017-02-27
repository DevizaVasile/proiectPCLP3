-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2017 at 12:17 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `comenzi_personale`
--

CREATE TABLE `comenzi_personale` (
  `id` int(11) NOT NULL,
  `ora_plasare` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comanda` varchar(5000) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comenzi_total`
--

CREATE TABLE `comenzi_total` (
  `id` int(10) NOT NULL,
  `mancare` varchar(255) NOT NULL,
  `cantitate` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='MENIU CANTINA MEMORANDULUIDATA: 16.01.2017';

--
-- Dumping data for table `comenzi_total`
--

INSERT INTO `comenzi_total` (`id`, `mancare`, `cantitate`) VALUES
(226, 'CIORBA DE PERISOARE CU PULPA DE PORC', 0),
(227, 'CIORBA DE FASOLE VERDE CU SMANTANA', 0),
(228, 'PILAF DE OREZ CU MORCOVI', 0),
(229, 'PIURE DE CARTOFI CU UNT', 0),
(230, 'CASCAVAL PANE', 0),
(231, 'CONOPIDA CU SMANTANA', 0),
(232, 'GRATAR COTLET PORC', 0),
(233, 'CARTOFI GRATINATI', 0),
(234, 'MAMALIGA CU BRANZA SI SMANTANA', 0),
(235, 'SPAGHETE BOLOGNEZE', 0),
(236, 'VARZA CALITA CU PULPA DE PORC', 0),
(237, 'FRIPTURA PULPA PORC CU ROSII', 0),
(238, 'FRIPTURA PORC CU CIUPERCI', 0),
(239, 'SALATA DE SFECLA ROSIE', 0),
(240, 'SALATA DE MURATURI ASORTATE', 0),
(241, 'SALATA DE CASTRAVETI IN OTET', 0);

-- --------------------------------------------------------

--
-- Table structure for table `meniu`
--

CREATE TABLE `meniu` (
  `id` int(10) NOT NULL,
  `mancare` varchar(1000) NOT NULL,
  `pret` float NOT NULL,
  `gramaj` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='MENIU CANTINA MEMORANDULUIDATA: 16.01.2017';

--
-- Dumping data for table `meniu`
--

INSERT INTO `meniu` (`id`, `mancare`, `pret`, `gramaj`) VALUES
(675, 'CIORBA DE PERISOARE CU PULPA DE PORC', 4.1, '70/330 gr'),
(676, 'CIORBA DE FASOLE VERDE CU SMANTANA', 2.2, '400 gr'),
(677, 'PILAF DE OREZ CU MORCOVI', 1.4, '300 gr'),
(678, 'PIURE DE CARTOFI CU UNT', 1.3, '300 gr'),
(679, 'CASCAVAL PANE', 3.6, '120 gr'),
(680, 'CONOPIDA CU SMANTANA', 3.4, '300 gr'),
(681, 'GRATAR COTLET PORC', 5.1, '108 gr'),
(682, 'CARTOFI GRATINATI', 2.4, '260 gr'),
(683, 'MAMALIGA CU BRANZA SI SMANTANA', 2.9, '200/50/80 gr'),
(684, 'SPAGHETE BOLOGNEZE', 2.8, '300gr'),
(685, 'VARZA CALITA CU PULPA DE PORC', 3.4, '50/250 gr'),
(686, 'FRIPTURA PULPA PORC CU ROSII', 3.4, '90/200 gr'),
(687, 'FRIPTURA PORC CU CIUPERCI', 3.9, '90/120 gr'),
(688, 'SALATA DE SFECLA ROSIE', 1.2, '120 gr'),
(689, 'SALATA DE MURATURI ASORTATE', 2.2, '150 gr'),
(690, 'SALATA DE CASTRAVETI IN OTET', 1.1, '120 gr');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `key` char(10) NOT NULL,
  `sold` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `password`, `reg_date`, `active`, `key`, `sold`) VALUES
(25, 'c', 'devizadeviza', '2016-12-15 13:45:22', 1, '34982910', 461.8),
(23, 'deviza.vasile111@student.unitbv.ro', 'devizadeviza123', '2016-12-08 19:25:28', 1, '64656982', 475.9),
(22, 'devizavasile1@student.unitbv.ro', 'dddddddddd', '2016-12-08 19:21:12', 1, '12345234', 0),
(21, 'devizavasile@student.unitbv.ro', 'devizadeviza', '2016-12-08 19:07:25', 1, '13246578', 0),
(24, 'sdfhj@student.unitbv.ro', '1234567890', '2016-12-08 22:25:00', 1, '64890441', 0),
(26, 'tehonlogiainformatiei@gmail.com', 'devizadeviza', '2016-12-15 13:46:38', 1, '55793762', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comenzi_personale`
--
ALTER TABLE `comenzi_personale`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `comenzi_total`
--
ALTER TABLE `comenzi_total`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mancare` (`mancare`);

--
-- Indexes for table `meniu`
--
ALTER TABLE `meniu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comenzi_personale`
--
ALTER TABLE `comenzi_personale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comenzi_total`
--
ALTER TABLE `comenzi_total`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;
--
-- AUTO_INCREMENT for table `meniu`
--
ALTER TABLE `meniu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=691;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
