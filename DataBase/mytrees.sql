-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 09:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mytrees`
--

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `Id_Country` int(2) NOT NULL,
  `Country_Name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`Id_Country`, `Country_Name`) VALUES
(1, 'Costa Rica');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `Id_District` int(2) NOT NULL,
  `District_Name` varchar(50) DEFAULT NULL,
  `Province_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`Id_District`, `District_Name`, `Province_Id`) VALUES
(1, 'Carmen', 1),
(2, 'Merced', 1),
(3, 'Hospital', 1),
(4, 'Catedral', 1),
(5, 'Zapote', 1),
(6, 'San Francisco de Dos Ríos', 1),
(7, 'Uruca', 1),
(8, 'Mata Redonda', 1),
(9, 'Pavas', 1),
(10, 'Hatillo', 1),
(11, 'San Sebastián', 1),
(12, 'Alajuela', 2),
(13, 'San Ramón', 2),
(14, 'Grecia', 2),
(15, 'San Mateo', 2),
(16, 'Atenas', 2),
(17, 'Naranjo', 2),
(18, 'Palmares', 2),
(19, 'Poás', 2),
(20, 'Orotina', 2),
(21, 'San Carlos', 2),
(22, 'Zarcero', 2),
(23, 'Valverde Vega', 2),
(24, 'Upala', 2),
(25, 'Los Chiles', 2),
(26, 'Guatuso', 2),
(27, 'Cartago', 3),
(28, 'Paraíso', 3),
(29, 'La Unión', 3),
(30, 'Jiménez', 3),
(31, 'Turrialba', 3),
(32, 'Alvarado', 3),
(33, 'Oreamuno', 3),
(34, 'El Guarco', 3),
(35, 'Heredia', 4),
(36, 'Barva', 4),
(37, 'Santo Domingo', 4),
(38, 'Santa Bárbara', 4),
(39, 'San Rafael', 4),
(40, 'San Isidro', 4),
(41, 'Belén', 4),
(42, 'Flores', 4),
(43, 'San Pablo', 4),
(44, 'Sarapiquí', 4),
(45, 'Liberia', 5),
(46, 'Nicoya', 5),
(47, 'Santa Cruz', 5),
(48, 'Bagaces', 5),
(49, 'Carrillo', 5),
(50, 'Cañas', 5),
(51, 'Abangares', 5),
(52, 'Tilarán', 5),
(53, 'Nandayure', 5),
(54, 'La Cruz', 5),
(55, 'Hojancha', 5),
(56, 'Puntarenas', 6),
(57, 'Esparza', 6),
(58, 'Buenos Aires', 6),
(59, 'Montes de Oro', 6),
(60, 'Osa', 6),
(61, 'Quepos', 6),
(62, 'Golfito', 6),
(63, 'Coto Brus', 6),
(64, 'Parrita', 6),
(65, 'Corredores', 6),
(66, 'Garabito', 6),
(67, 'Limón', 7),
(68, 'Pococí', 7),
(69, 'Siquirres', 7),
(70, 'Talamanca', 7),
(71, 'Matina', 7),
(72, 'Guácimo', 7),
(73, 'Oriental', 3),
(74, 'Occidental', 3),
(75, 'Carmen', 3),
(76, 'San Nicolás', 3),
(77, 'Aguacaliente', 3),
(78, 'Guadalupe', 3),
(79, 'Corralillo', 3),
(80, 'Tierra Blanca', 3),
(81, 'Dulce Nombre', 3),
(82, 'Llano Grande', 3),
(83, 'Quebradilla', 3),
(84, 'Paraíso', 3),
(85, 'Santiago', 3),
(86, 'Orosi', 3),
(87, 'Cachí', 3),
(88, 'La Unión', 3),
(89, 'Tres Ríos', 3),
(90, 'San Diego', 3),
(91, 'San Juan', 3),
(92, 'San Rafael', 3),
(93, 'Concepción', 3),
(94, 'Dulce Nombre', 3),
(95, 'San Ramón', 3),
(96, 'Río Azul', 3),
(97, 'Heredia', 4),
(98, 'Mercedes', 4),
(99, 'San Francisco', 4),
(100, 'Ulloa', 4),
(101, 'Varablanca', 4),
(102, 'Barva', 4),
(103, 'San Pedro', 4),
(104, 'San Pablo', 4),
(105, 'San Roque', 4),
(106, 'Santa Lucía', 4),
(107, 'San José de la Montaña', 4),
(108, 'Santo Domingo', 4),
(109, 'San Vicente', 4),
(110, 'San Miguel', 4),
(111, 'Paracito', 4),
(112, 'Santo Tomás', 4),
(113, 'Santa Rosa', 4),
(114, 'Tures', 4),
(115, 'Pará', 4),
(116, 'San Rafael', 4),
(117, 'San Josecito', 4),
(118, 'Santiago', 4),
(119, 'Ángeles', 4),
(120, 'Concepción', 4),
(121, 'San Isidro', 4),
(122, 'San José', 4),
(123, 'Concepción', 4),
(124, 'San Francisco', 4),
(125, 'Belén', 4),
(126, 'La Ribera', 4),
(127, 'La Asunción', 4),
(128, 'Liberia', 5),
(129, 'Cañas Dulces', 5),
(130, 'Mayorga', 5),
(131, 'Nacascolo', 5),
(132, 'Curubandé', 5),
(133, 'Nicoya', 5),
(134, 'Mansión', 5),
(135, 'San Antonio', 5),
(136, 'Quebrada Honda', 5),
(137, 'Sámara', 5),
(138, 'Nosara', 5),
(139, 'Belén de Nosarita', 5),
(140, 'Santa Cruz', 5),
(141, 'Bolsón', 5),
(142, 'Veintisiete de Abril', 5),
(143, 'Tempate', 5),
(144, 'Cartagena', 5),
(145, 'Cuajiniquil', 5),
(146, 'Diriá', 5),
(147, 'Cabo Velas', 5),
(148, 'Tamarindo', 5),
(149, 'Puntarenas', 6),
(150, 'Pitahaya', 6),
(151, 'Chomes', 6),
(152, 'Lepanto', 6),
(153, 'Paquera', 6),
(154, 'Manzanillo', 6),
(155, 'Guacimal', 6),
(156, 'Barranca', 6),
(157, 'Monte Verde', 6),
(158, 'Isla del Coco', 6),
(159, 'Esparza', 6),
(160, 'San Jerónimo', 6),
(161, 'San Juan Grande', 6),
(162, 'San Rafael', 6),
(163, 'San Isidro', 6),
(164, 'Miramar', 6),
(165, 'La Unión', 6),
(166, 'San Isidro', 6),
(167, 'Limón', 7),
(168, 'Valle La Estrella', 7),
(169, 'Río Blanco', 7),
(170, 'Matama', 7),
(171, 'Guápiles', 7),
(172, 'Jiménez', 7),
(173, 'Rita', 7),
(174, 'Roxana', 7),
(175, 'Cariari', 7),
(176, 'Colorado', 7),
(177, 'Siquirres', 7),
(178, 'Pacuarito', 7),
(179, 'Florida', 7),
(180, 'Germania', 7),
(181, 'Cairo', 7),
(182, 'Alegría', 7),
(183, 'Matina', 7),
(184, 'Batán', 7),
(185, 'Carrandi', 7),
(186, 'Bratsi', 7),
(187, 'Sixaola', 7),
(188, 'Cahuita', 7),
(189, 'Telire', 7),
(190, 'Guácimo', 7),
(191, 'Mercedes', 7),
(192, 'Pocora', 7),
(193, 'Río Jiménez', 7),
(194, 'Duacarí', 7);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `Id_Province` int(2) NOT NULL,
  `Province_Name` varchar(50) DEFAULT NULL,
  `Country_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`Id_Province`, `Province_Name`, `Country_Id`) VALUES
(1, 'San José', 1),
(2, 'Alajuela', 1),
(3, 'Cartago', 1),
(4, 'Heredia', 1),
(5, 'Guanacaste', 1),
(6, 'Puntarenas', 1),
(7, 'Limón', 1);

-- --------------------------------------------------------

--
-- Table structure for table `species`
--

CREATE TABLE `species` (
  `Id_Specie` int(11) NOT NULL,
  `Commercial_Name` varchar(100) DEFAULT NULL,
  `Scientific_Name` varchar(100) DEFAULT NULL,
  `StatusS` int(2) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `species`
--

INSERT INTO `species` (`Id_Specie`, `Commercial_Name`, `Scientific_Name`, `StatusS`) VALUES
(1, 'Guanacaste', 'Enterolobium cyclocarpum', 1),
(2, 'Cedar', 'Cedrela odorata', 1),
(3, 'Pochote', 'Pochota guanacastensis', 1),
(4, 'Roble', 'Tabebuia rosea', 1),
(5, 'Ciprés', 'Cupressus lusitanica', 1),
(6, 'Aguacate', 'Persea americana', 1),
(7, 'Bamboo', 'Bambusa vulgaris', 1),
(8, 'Árbol de la vida', 'Guaiacum sanctum', 1),
(9, 'Guayabo', 'Psidium guajava', 1),
(10, 'Cocobolo', 'Dalbergia retusa', 1),
(11, 'Cenízaro', 'Samanea saman', 1);

-- --------------------------------------------------------

--
-- Table structure for table `trees`
--

CREATE TABLE `trees` (
  `Id_Tree` int(11) NOT NULL,
  `Specie_Id` int(11) DEFAULT NULL,
  `Location` varchar(255) NOT NULL,
  `StatusT` tinyint(1) NOT NULL DEFAULT 1,
  `Price` decimal(10,2) NOT NULL,
  `Photo_Path` varchar(255) DEFAULT NULL,
  `User_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trees`
--

INSERT INTO `trees` (`Id_Tree`, `Specie_Id`, `Location`, `StatusT`, `Price`, `Photo_Path`, `User_Id`) VALUES
(1, 1, 'California, USA', 1, 150.00, 'photos/oak_tree.jpg', 3),
(2, 2, 'Oregon, USA', 1, 120.00, 'photos/pine_tree.jpg', 2),
(3, 3, 'Vermont, USA', 0, 200.00, 'photos/maple_tree.jpg', 3),
(4, 4, 'Maine, USA', 0, 180.00, 'photos/birch_tree.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id_User` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name1` varchar(50) NOT NULL,
  `Last_Name2` varchar(50) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Gender` char(1) DEFAULT NULL,
  `Profile_Pic` varchar(255) DEFAULT NULL,
  `District_Id` int(10) DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Role_Id` int(2) DEFAULT NULL,
  `StatusU` int(2) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id_User`, `First_Name`, `Last_Name1`, `Last_Name2`, `Username`, `Password`, `Email`, `Phone`, `Gender`, `Profile_Pic`, `District_Id`, `Created_At`, `Role_Id`, `StatusU`) VALUES
(0, 'Joselyn', 'Ojeda', 'Vargas', 'joselyn', '$2y$10$mqvcIq4vm94tv.VRlfqDGOeBn2EQda1YFOLYcdVzOy.Im2/3d8TYa', 'joselyn@gmail.com', '71591802', 'F', 'img/default_profile.png', 21, '2024-10-21 12:39:27', 2, 1),
(1, 'Admin', 'User', 'Admi', 'admin', '$2y$10$FKYX2EfTdIe.YdoIgJNV3.Yl9pL0jTHQvXW9d.Yj8pSOiJ76lbKDm', 'admin@gmail.com', '1234567890', 'M', 'img/default_profile.png', 1, '2024-10-19 23:24:03', 1, 1),
(2, 'Keiry', 'Chacón', 'Sibaja', 'kei', '$2y$10$FKYX2EfTdIe.YdoIgJNV3.Yl9pL0jTHQvXW9d.Yj8pSOiJ76lbKDm', 'keirychas@gmail.com', '86295417', 'F', 'img/default_profile.png', 21, '2024-10-20 09:18:03', 2, 1),
(3, 'Gredy', 'Corrales', 'Mendoza', 'gredy', '$2y$10$FKYX2EfTdIe.YdoIgJNV3.Yl9pL0jTHQvXW9d.Yj8pSOiJ76lbKDm', 'gredy@gmail.com', '71591802', 'M', 'img/default_profile.png', 21, '2024-10-21 07:23:30', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`Id_Country`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`Id_District`),
  ADD KEY `Province_Id` (`Province_Id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`Id_Province`),
  ADD KEY `Country_Id` (`Country_Id`);

--
-- Indexes for table `species`
--
ALTER TABLE `species`
  ADD PRIMARY KEY (`Id_Specie`);

--
-- Indexes for table `trees`
--
ALTER TABLE `trees`
  ADD PRIMARY KEY (`Id_Tree`),
  ADD KEY `Id_User` (`User_Id`),
  ADD KEY `fk_Specie_Id` (`Specie_Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id_User`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `uc_email` (`Email`),
  ADD UNIQUE KEY `uc_username` (`Username`),
  ADD KEY `District_Id` (`District_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `Id_Country` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `Id_District` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `Id_Province` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `species`
--
ALTER TABLE `species`
  MODIFY `Id_Specie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `trees`
--
ALTER TABLE `trees`
  MODIFY `Id_Tree` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `district_ibfk_1` FOREIGN KEY (`Province_Id`) REFERENCES `province` (`Id_Province`);

--
-- Constraints for table `province`
--
ALTER TABLE `province`
  ADD CONSTRAINT `province_ibfk_1` FOREIGN KEY (`Country_Id`) REFERENCES `country` (`Id_Country`);

--
-- Constraints for table `trees`
--
ALTER TABLE `trees`
  ADD CONSTRAINT `fk_Specie_Id` FOREIGN KEY (`Specie_Id`) REFERENCES `species` (`Id_Specie`),
  ADD CONSTRAINT `trees_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id_User`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`District_Id`) REFERENCES `district` (`Id_District`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
