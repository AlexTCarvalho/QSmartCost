-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 08-Nov-2018 às 03:16
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
-- Database: `lg_teste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `data_teste` date NOT NULL,
  `situacao` varchar(50) NOT NULL,
  `statusrohs` int(11) NOT NULL,
  `comentario` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id`, `nome`, `data_teste`, `situacao`, `statusrohs`, `comentario`) VALUES
(26, 'Item1_MWO_IQC6', '2018-11-01', 'NÃO_REALIZADO', 6, 'Jonatas Top!'),
(27, 'Item2_RAC_IQC6', '2018-11-05', 'NÃO_REALIZADO', 6, 'Esse também. agora hkjhjupur hjkajgfajhlb fo ajhfna m~foiçqkhfnajk hj flafkjafjkahlfkjhaljfkhajf jfn ufhjgqjhfaglfjkahkjfhaçkfhajkfhakjfh haqytruyqtuyrtquytruyqth hgfjhagfhajgfkjhagfjkhgajkhgfjkha hajklakjhflakjfhaccnjjfkajdlakjfçalk.'),
(29, 'Item5_RAC_IQC6', '2018-11-14', 'NÃO_REALIZADO', 6, NULL),
(30, 'Item6_MWO_IQC6', '2018-11-21', 'NÃO_REALIZADO', 6, NULL),
(31, 'Item1_MWO_IQC6', '2018-09-03', 'NÃO_REALIZADO', 7, NULL),
(32, 'Item2_RAC_IQC6', '2018-09-05', 'NÃO_REALIZADO', 7, NULL),
(33, 'Item4_MWO_IQC6', '2018-09-06', 'NÃO_REALIZADO', 7, NULL),
(34, 'Item5_RAC_IQC6', '2018-09-06', 'NÃO_REALIZADO', 7, NULL),
(35, 'Item6_MWO_IQC6', '2018-09-12', 'NÃO_REALIZADO', 7, NULL),
(89, 'Item1_MWO_IQC6', '2018-02-01', 'REALIZADO', 37, NULL),
(90, 'Item2_RAC_IQC6', '2018-02-05', 'NÃO_REALIZADO', 37, NULL),
(91, 'Item4_MWO_IQC6', '2018-02-05', 'NÃO_REALIZADO', 37, NULL),
(92, 'Item5_RAC_IQC6', '2018-02-06', 'NÃO_REALIZADO', 37, NULL),
(93, 'Item6_MWO_IQC6', '2018-02-06', 'NÃO_REALIZADO', 37, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1540698947),
('m130524_201442_init', 1540698951);

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusrohs`
--

CREATE TABLE `statusrohs` (
  `id` int(11) NOT NULL,
  `month` varchar(10) NOT NULL,
  `status` varchar(15) DEFAULT NULL,
  `reason` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `statusrohs`
--

INSERT INTO `statusrohs` (`id`, `month`, `status`, `reason`) VALUES
(6, 'NOV\'18', 'PENDING', NULL),
(7, 'SET\'18', 'PENDING', NULL),
(37, 'FEV\'18', 'APPROVED', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `subitem`
--

CREATE TABLE `subitem` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `data_teste` date NOT NULL,
  `item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `subitem`
--

INSERT INTO `subitem` (`id`, `nome`, `data_teste`, `item`) VALUES
(1, 'SubItem1', '2018-02-01', 89),
(2, 'SubItem2', '2018-02-01', 89),
(3, 'SubItem3', '2018-02-01', 89),
(4, 'SubItem4', '2018-02-01', 89),
(5, 'SubItem1', '2018-02-05', 90),
(6, 'SubItem2', '2018-02-05', 90),
(7, 'SubItem3', '2018-02-05', 90),
(8, 'SubItem4', '2018-02-05', 90),
(9, 'SubItem1', '2018-02-05', 91),
(10, 'SubItem2', '2018-02-05', 91),
(11, 'SubItem3', '2018-02-05', 91),
(12, 'SubItem4', '2018-02-05', 91),
(13, 'SubItem1', '2018-02-06', 92),
(14, 'SubItem2', '2018-02-06', 92),
(15, 'SubItem3', '2018-02-06', 92),
(16, 'SubItem4', '2018-02-06', 92),
(17, 'SubItem1', '2018-02-06', 93),
(18, 'SubItem2', '2018-02-06', 93),
(19, 'SubItem3', '2018-02-06', 93),
(20, 'SubItem4', '2018-02-06', 93);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statusrohs` (`statusrohs`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `statusrohs`
--
ALTER TABLE `statusrohs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subitem`
--
ALTER TABLE `subitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item` (`item`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `statusrohs`
--
ALTER TABLE `statusrohs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `subitem`
--
ALTER TABLE `subitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`statusrohs`) REFERENCES `statusrohs` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `subitem`
--
ALTER TABLE `subitem`
  ADD CONSTRAINT `subitem_ibfk_1` FOREIGN KEY (`item`) REFERENCES `item` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
