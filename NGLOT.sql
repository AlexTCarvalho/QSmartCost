-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 17-Jan-2019 às 22:04
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lg`
--

--
-- Extraindo dados da tabela `nglot_acc`
--

INSERT INTO `nglot_acc` (`id`, `ng`, `total`, `ppm`, `month`, `year`) VALUES
(1, 0, 302, 0, 1, 2018),
(2, 0, 153, 0, 2, 2018),
(3, 3, 243, 12346, 3, 2018),
(4, 0, 200, 0, 4, 2018),
(5, 0, 170, 0, 5, 2018),
(6, 0, 15, 0, 6, 2018),
(7, 0, 166, 0, 7, 2018),
(8, 6, 263, 22814, 8, 2018),
(9, 0, 198, 0, 9, 2018),
(10, 0, 218, 0, 10, 2018),
(11, 1, 289, 3460, 11, 2018),
(12, 0, 183, 0, 12, 2018);

--
-- Extraindo dados da tabela `nglot_w`
--

INSERT INTO `nglot_w` (`id`, `ng`, `total`, `ppm`, `week`, `month`, `year`) VALUES
(1, 1, 29, 34483, 3, 1, 2019),
(2, 0, 19, 0, 1, 1, 2019),
(3, 0, 39, 0, 2, 1, 2019);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
