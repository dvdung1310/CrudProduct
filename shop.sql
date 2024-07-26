-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for shop
CREATE DATABASE IF NOT EXISTS `shop` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `shop`;

-- Dumping structure for table shop.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.category: ~0 rows (approximately)
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'Electronics'),
	(2, 'Clothing'),
	(3, 'Books');

-- Dumping structure for table shop.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `category_id` int DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shop.product: ~9 rows (approximately)
INSERT INTO `product` (`id`, `name`, `description`, `price`, `category_id`, `images`, `created_at`, `updated_at`) VALUES
	(7, 'Electronics', '<ul><li>oke luôn</li></ul>', 111.00, 1, 'uploads/images_product/1721975670_clothes.png', '2024-07-25 23:34:30', '2024-07-26 01:01:30'),
	(8, 'Books', '<p>quần đùi áo số 2</p>', 50000.00, 3, 'uploads/images_product/1721977240_product-QR.png', '2024-07-26 00:00:40', '2024-07-26 01:01:21'),
	(9, 'Books', '123', 1250000.00, 3, 'uploads/images_product/1721978202_hinh.png', '2024-07-26 00:16:42', '2024-07-26 00:21:13'),
	(10, 'Electronics', '<ul><li>ảnh đẹp quá đi</li></ul>', 50000.00, 1, 'uploads/images_product/1721980301_bongdentoitest.png', '2024-07-26 00:51:41', '2024-07-26 01:23:40'),
	(11, 'Electronics', '<ul><li>chất liệu lớp oke</li></ul>', 2999.98, 1, 'uploads/images_product/1721980920_bongdentoitest.png', '2024-07-26 01:02:00', '2024-07-26 01:23:33'),
	(12, 'Electronics', '<p>11</p>', 111.00, 1, 'uploads/images_product/1721981463_service.png', '2024-07-26 01:02:40', '2024-07-26 01:11:03'),
	(13, 'Electronics', '<ul><li>oke</li><li>qua duoc</li></ul>', 100000.00, 1, 'uploads/images_product/1721982094_Screenshot 2023-08-14 145907.png', '2024-07-26 01:06:41', '2024-07-26 01:21:34');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
