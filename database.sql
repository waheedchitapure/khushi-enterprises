-- ===================================================================
-- Khushi Enterprises - B2B Wholesale Database Schema
-- Compatible with GoDaddy MySQL / phpMyAdmin / MariaDB
-- ===================================================================

CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(60) NOT NULL UNIQUE,
  `name` VARCHAR(100) NOT NULL,
  `description` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `category` VARCHAR(60) NOT NULL,
  `category_label` VARCHAR(100) NOT NULL,
  `brand` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `image` VARCHAR(255) NOT NULL,
  `wholesale_only` TINYINT(1) DEFAULT 1,
  `min_order_note` VARCHAR(255) DEFAULT 'Available in Wholesale Packing / Box Quantities',
  `whatsapp_message` TEXT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (`category`),
  INDEX (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `enquiries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `shop_name` VARCHAR(150) NULL,
  `phone` VARCHAR(30) NOT NULL,
  `city` VARCHAR(100) NULL,
  `message` TEXT NOT NULL,
  `ip_address` VARCHAR(50) NULL,
  `user_agent` VARCHAR(255) NULL,
  `status` ENUM('new', 'contacted', 'closed') DEFAULT 'new',
  `created_at` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Default Categories
INSERT INTO `categories` (`slug`, `name`, `description`) VALUES
('bath-fittings', 'Bath Taps & Showers', 'CP taps, bib cocks, angle valves, pillar cocks, overhead rain showers, health faucets'),
('waste-drain', 'Drain & Waste Systems', 'Stainless steel sink waste couplings, floor drain jalis, cockroach traps, flexible waste pipes'),
('pipes-hoses', 'Pipes & Hoses', 'PVC braided garden hose rolls, green suction pipes, transparent water level tubes'),
('drain-cleaners', 'Cleaners & Chemicals', 'Kadam Dr. Flow drain cleaners, Chock-up liquid, Caustic soda, bleaching powder, plungers'),
('cistern-toilet', 'Cistern & Seat Covers', 'PVC flushing tanks, commode seat covers, siphon washers, internal float valve mechanisms'),
('valves-hardware', 'Valves & Fasteners', 'Brass ball valves, NRV check valves, UPVC valves, ceramic spindles, hex nipples, Allen keys'),
('hardware', 'General Hardware', 'Plastic tasla/ghamela, nylon wall plugs gitti, wooden pegs, Ivy Grip nano tapes'),
('electrical-conduit', 'Electrical Conduit', 'PVC conduit pipes, deep circular junction boxes, tees, bends, modular fan box covers')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);
