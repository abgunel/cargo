-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 13 Mar 2024, 14:06:30
-- Sunucu sürümü: 8.0.31
-- PHP Sürümü: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `cargo`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cargofirm`
--

DROP TABLE IF EXISTS `cargofirm`;
CREATE TABLE IF NOT EXISTS `cargofirm` (
  `CargoFirmId` int NOT NULL,
  `CargoFirm` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`CargoFirmId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cargostatus`
--

DROP TABLE IF EXISTS `cargostatus`;
CREATE TABLE IF NOT EXISTS `cargostatus` (
  `CargoStatusId` int NOT NULL,
  `CargoStatus` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`CargoStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `OrderedDepId` int NOT NULL,
  `OrderedDep` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`OrderedDepId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `DateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `OrderName` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Orderer` int NOT NULL,
  `OrderedDepId` int NOT NULL,
  `OrderedPro` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `OrderLink` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `OrderImage` varchar(255) DEFAULT NULL,
  `OrderDescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `CargoPostDate` date DEFAULT NULL,
  `CargoFirmId` int DEFAULT NULL,
  `CargoTrackingCode` int DEFAULT NULL,
  `CargoStatusId` int DEFAULT '10',
  `OrderReceived` tinyint(1) NOT NULL DEFAULT '0',
  `CargoReceiver` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ReceiverImage` longtext,
  PRIMARY KEY (`Id`),
  KEY `orders_ibfk_1` (`CargoStatusId`),
  KEY `orders_ibfk_2` (`OrderedDepId`),
  KEY `orders_ibfk_3` (`CargoFirmId`),
  KEY `OrderReceived` (`OrderReceived`),
  KEY `Orderer` (`Orderer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `receive`
--

DROP TABLE IF EXISTS `receive`;
CREATE TABLE IF NOT EXISTS `receive` (
  `Id` tinyint(1) NOT NULL,
  `ReceiveStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `receiveimage`
--

DROP TABLE IF EXISTS `receiveimage`;
CREATE TABLE IF NOT EXISTS `receiveimage` (
  `Id` int NOT NULL,
  `Image` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `RoleId` int NOT NULL,
  `RoleName` varchar(30) NOT NULL,
  PRIMARY KEY (`RoleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(25) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RoleId` int NOT NULL,
  `DepId` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `RoleId` (`RoleId`),
  KEY `DepId` (`DepId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CargoStatusId`) REFERENCES `cargostatus` (`CargoStatusId`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`OrderedDepId`) REFERENCES `departments` (`OrderedDepId`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`CargoFirmId`) REFERENCES `cargofirm` (`CargoFirmId`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`OrderReceived`) REFERENCES `receive` (`Id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`Orderer`) REFERENCES `users` (`Id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Tablo kısıtlamaları `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleId`) REFERENCES `role` (`RoleId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`DepId`) REFERENCES `departments` (`OrderedDepId`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
