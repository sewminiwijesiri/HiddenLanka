-- ===================================================
-- Hidden Lanka Database Schema
-- Database: hidden_lanka_db
-- ===================================================

CREATE DATABASE IF NOT EXISTS `hidden_lanka_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `hidden_lanka_db`;

-- --------------------------------------------------------
-- Table structure for `admins`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default Admin Credentials (username: admin, password: admin123)
INSERT INTO `admins` (`username`, `password_hash`) VALUES
('admin', '$2y$10$FTR5VdIv.ZuosGQ7pzS8cuAFEL7kdYB1QCzLauy7E9IDLXoT6NDh2')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- --------------------------------------------------------
-- Table structure for `accommodations`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `accommodations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `subtitle` VARCHAR(255) DEFAULT '',
  `description` TEXT,
  `badge` VARCHAR(100) DEFAULT '',
  `image_path` VARCHAR(255) DEFAULT '',
  `amenities` TEXT,
  `price` VARCHAR(100) DEFAULT '',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `accommodation_images`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `accommodation_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `accommodation_id` INT NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`accommodation_id`) REFERENCES `accommodations`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `tours`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tours` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `subtitle` VARCHAR(255) DEFAULT '',
  `description` TEXT,
  `badge` VARCHAR(100) DEFAULT '',
  `image_path` VARCHAR(255) DEFAULT '',
  `duration` VARCHAR(100) DEFAULT '',
  `price` VARCHAR(100) DEFAULT 'Custom Rates',
  `places` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `reviews`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `rating` TINYINT NOT NULL DEFAULT 5,
  `title` VARCHAR(255) DEFAULT '',
  `content` TEXT NOT NULL,
  `avatar_initials` VARCHAR(10) DEFAULT 'G',
  `country` VARCHAR(100) DEFAULT '',
  `trip_type` VARCHAR(100) DEFAULT '',
  `review_type` VARCHAR(50) DEFAULT 'general',
  `is_approved` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `gallery`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) DEFAULT '',
  `caption` TEXT DEFAULT '',
  `image_path` VARCHAR(255) NOT NULL,
  `category` VARCHAR(100) DEFAULT 'general',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
