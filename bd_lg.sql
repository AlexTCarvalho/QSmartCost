-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 19-Dez-2018 às 20:34
-- Versão do servidor: 10.1.36-MariaDB
-- versão do PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_lg`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fcr_acc`
--

CREATE TABLE `fcr_acc` (
  `id` int(11) NOT NULL,
  `failcost` double NOT NULL,
  `sales` double NOT NULL,
  `rate` double NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fcr_w`
--

CREATE TABLE `fcr_w` (
  `id` int(11) NOT NULL,
  `failcost` double NOT NULL,
  `sales` double NOT NULL,
  `rate` double NOT NULL,
  `week` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ffr_acc`
--

CREATE TABLE `ffr_acc` (
  `id` int(11) NOT NULL,
  `accsvc` int(11) NOT NULL,
  `waccs` int(11) NOT NULL,
  `rate` double NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ffr_acc`
--

INSERT INTO `ffr_acc` (`id`, `accsvc`, `waccs`, `rate`, `month`, `year`) VALUES
(1, 3584, 136541, 2.62, 1, 2017),
(2, 3361, 145608, 2.31, 2, 2017),
(3, 3310, 152022, 2.18, 3, 2017),
(4, 3270, 142719, 2.29, 4, 2017),
(5, 3322, 134140, 2.48, 5, 2017),
(6, 3222, 133253, 2.42, 6, 2017),
(7, 3143, 140669, 2.23, 7, 2017),
(8, 3060, 144399, 2.12, 8, 2017),
(9, 2908, 140705, 2.07, 9, 2017),
(10, 2727, 138474, 1.97, 10, 2017),
(11, 2458, 136468, 1.8, 11, 2017),
(12, 2447, 142440, 1.72, 12, 2017),
(13, 2400, 143427, 1.67, 1, 2018),
(14, 2362, 151251, 1.56, 2, 2018),
(15, 2406, 160559, 1.5, 3, 2018),
(16, 2603, 170858, 1.52, 4, 2018),
(17, 2651, 179032, 1.48, 5, 2018),
(18, 2744, 187062, 1.47, 6, 2018),
(19, 2828, 190924, 1.48, 7, 2018),
(20, 2782, 188588, 1.48, 8, 2018),
(21, 2600, 180993, 1.44, 9, 2018),
(22, 2455, 162927, 1.51, 10, 2018),
(23, 2280, 151417, 1.51, 11, 2018),
(24, 2056, 145017, 1.42, 12, 2018);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ffr_w`
--

CREATE TABLE `ffr_w` (
  `id` int(11) NOT NULL,
  `accsvc` int(11) NOT NULL,
  `waccs` int(11) NOT NULL,
  `rate` double NOT NULL,
  `week` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ffr_w`
--

INSERT INTO `ffr_w` (`id`, `accsvc`, `waccs`, `rate`, `week`, `month`, `year`) VALUES
(1, 2167, 133776, 1.62, 47, 11, 2018),
(2, 2267, 139388, 1.63, 48, 11, 2018),
(3, 1954, 116491, 1.68, 49, 12, 2018),
(4, 2038, 121293, 1.68, 50, 12, 2018),
(5, 2081, 145129, 1.43, 51, 12, 2018);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ifrr_acc`
--

CREATE TABLE `ifrr_acc` (
  `id` int(11) NOT NULL,
  `rework` int(11) NOT NULL,
  `tpq` int(11) NOT NULL,
  `ppm` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ifrr_acc`
--

INSERT INTO `ifrr_acc` (`id`, `rework`, `tpq`, `ppm`, `month`, `year`) VALUES
(1, 182, 32345, 5627, 1, 2017),
(2, 0, 22707, 0, 2, 2017),
(3, 95, 30439, 3121, 3, 2017),
(4, 61, 24968, 2470, 4, 2017),
(5, 1122, 35330, 31758, 5, 2017),
(6, 13, 26371, 493, 6, 2017),
(7, 729, 26078, 27955, 7, 2017),
(8, 60, 27758, 2162, 8, 2017),
(9, 50, 34505, 1449, 9, 2017),
(10, 300, 35034, 8563, 10, 2017),
(11, 0, 33420, 0, 11, 2017),
(12, 70, 31688, 2209, 12, 2017),
(13, 0, 42090, 0, 1, 2018),
(14, 0, 36426, 0, 2, 2018),
(15, 235, 35592, 6603, 3, 2018),
(16, 0, 14590, 0, 4, 2018),
(17, 321, 39573, 8112, 5, 2018),
(18, 0, 0, 0, 6, 2018),
(19, 0, 34170, 0, 7, 2018),
(20, 0, 35185, 0, 8, 2018),
(21, 115, 24735, 4649, 9, 2018),
(22, 0, 34500, 0, 10, 2018),
(23, 0, 38864, 0, 11, 2018);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ifrr_w`
--

CREATE TABLE `ifrr_w` (
  `id` int(11) NOT NULL,
  `rework` int(11) NOT NULL,
  `tpq` int(11) NOT NULL,
  `ppm` int(11) NOT NULL,
  `week` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ifrr_w`
--

INSERT INTO `ifrr_w` (`id`, `rework`, `tpq`, `ppm`, `week`, `month`, `year`) VALUES
(1, 0, 3664, 0, 50, 12, 2018),
(2, 0, 3703, 0, 50, 12, 2018),
(3, 0, 10005, 0, 48, 11, 2018),
(4, 0, 7456, 0, 49, 12, 2018),
(5, 0, 4296, 0, 50, 12, 2018);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prr_acc`
--

CREATE TABLE `prr_acc` (
  `id` int(11) NOT NULL,
  `ppq` int(11) NOT NULL,
  `prodquant` int(11) NOT NULL,
  `ppm` double NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `prr_acc`
--

INSERT INTO `prr_acc` (`id`, `ppq`, `prodquant`, `ppm`, `month`, `year`) VALUES
(1, 0, 54650, 0, 1, 2017),
(2, 1, 44173, 23, 2, 2017),
(3, 11, 33029, 333, 3, 2017),
(4, 10, 24968, 401, 4, 2017),
(5, 28, 36200, 773, 5, 2017),
(6, 15, 27572, 544, 6, 2017),
(7, 11, 33920, 324, 7, 2017),
(8, 41, 54286, 755, 8, 2017),
(9, 32, 68866, 465, 9, 2017),
(10, 54, 70511, 766, 10, 2017),
(11, 52, 67605, 769, 11, 2017),
(12, 52, 62888, 830, 12, 2017),
(13, 60, 82457, 728, 1, 2018),
(14, 28, 41212, 679, 2, 2018),
(15, 27, 57137, 473, 3, 2018),
(16, 13, 41619, 312, 4, 2018),
(17, 20, 39985, 500, 5, 2018),
(18, 0, 1144, 0, 6, 2018),
(19, 1, 34826, 29, 7, 2018),
(20, 29, 69061, 420, 8, 2018),
(21, 23, 53598, 429, 9, 2018),
(22, 33, 67925, 486, 10, 2018),
(23, 22, 76159, 289, 11, 2018);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prr_w`
--

CREATE TABLE `prr_w` (
  `id` int(11) NOT NULL,
  `ppq` int(11) NOT NULL,
  `prodquant` int(11) NOT NULL,
  `ppm` double NOT NULL,
  `week` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `prr_w`
--

INSERT INTO `prr_w` (`id`, `ppq`, `prodquant`, `ppm`, `week`, `month`, `year`) VALUES
(1, 26, 16966, 1532, 47, 11, 2018),
(2, 24, 23164, 1036, 48, 11, 2018),
(3, 12, 14606, 821, 49, 12, 2018),
(4, 1, 2688, 372, 50, 12, 2018),
(5, 4, 7582, 528, 50, 12, 2018),
(6, 4, 7671, 521, 50, 12, 2018),
(7, 3, 9364, 320, 50, 12, 2018),
(8, 3, 9691, 310, 50, 12, 2018),
(9, 3, 10557, 284, 50, 12, 2018);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tldr_acc`
--

CREATE TABLE `tldr_acc` (
  `id` int(11) NOT NULL,
  `defect` int(11) NOT NULL,
  `tpq` int(11) NOT NULL,
  `ppm` double NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tldr_acc`
--

INSERT INTO `tldr_acc` (`id`, `defect`, `tpq`, `ppm`, `month`, `year`) VALUES
(1, 93, 42090, 2210, 1, 2018),
(2, 68, 36426, 1867, 2, 2018),
(3, 104, 35592, 2978, 3, 2018),
(4, 28, 14590, 1919, 4, 2018),
(5, 138, 39573, 3487, 5, 2018),
(6, 0, 0, 0, 6, 2018),
(7, 36, 34170, 1054, 7, 2018),
(8, 130, 35182, 3695, 8, 2018),
(9, 117, 24735, 4771, 9, 2018),
(10, 79, 34500, 2290, 10, 2018),
(11, 106, 38864, 2728, 11, 2018),
(12, 118, 32345, 3648, 1, 2017),
(13, 80, 22707, 3523, 2, 2017),
(14, 86, 30439, 2825, 3, 2017),
(15, 76, 24968, 3044, 4, 2017),
(16, 203, 35330, 5746, 5, 2017),
(17, 182, 26371, 6977, 6, 2017),
(18, 137, 26078, 5292, 7, 2017),
(19, 108, 27758, 3891, 8, 2017),
(20, 186, 34505, 5420, 9, 2017),
(21, 131, 35034, 3825, 10, 2017),
(22, 156, 33420, 4688, 11, 2017),
(23, 88, 31688, 2840, 12, 2017);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tldr_w`
--

CREATE TABLE `tldr_w` (
  `id` int(11) NOT NULL,
  `defect` int(11) NOT NULL,
  `tpq` int(11) NOT NULL,
  `ppm` double NOT NULL,
  `week` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tldr_w`
--

INSERT INTO `tldr_w` (`id`, `defect`, `tpq`, `ppm`, `week`, `month`, `year`) VALUES
(1, 10, 1967, 5084, 50, 12, 2018),
(2, 14, 3237, 4325, 50, 12, 2018),
(3, 15, 3617, 4147, 50, 12, 2018),
(4, 15, 3703, 4051, 50, 12, 2018),
(5, 21, 4296, 4888, 50, 12, 2018),
(6, 11, 10005, 5201, 48, 11, 2018),
(7, 7, 7456, 1477, 49, 12, 2018);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fcr_acc`
--
ALTER TABLE `fcr_acc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fcr_w`
--
ALTER TABLE `fcr_w`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ffr_acc`
--
ALTER TABLE `ffr_acc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ffr_w`
--
ALTER TABLE `ffr_w`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ifrr_acc`
--
ALTER TABLE `ifrr_acc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ifrr_w`
--
ALTER TABLE `ifrr_w`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prr_acc`
--
ALTER TABLE `prr_acc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prr_w`
--
ALTER TABLE `prr_w`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tldr_acc`
--
ALTER TABLE `tldr_acc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tldr_w`
--
ALTER TABLE `tldr_w`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fcr_acc`
--
ALTER TABLE `fcr_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fcr_w`
--
ALTER TABLE `fcr_w`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ffr_acc`
--
ALTER TABLE `ffr_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ffr_w`
--
ALTER TABLE `ffr_w`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ifrr_acc`
--
ALTER TABLE `ifrr_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ifrr_w`
--
ALTER TABLE `ifrr_w`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prr_acc`
--
ALTER TABLE `prr_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `prr_w`
--
ALTER TABLE `prr_w`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tldr_acc`
--
ALTER TABLE `tldr_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tldr_w`
--
ALTER TABLE `tldr_w`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
