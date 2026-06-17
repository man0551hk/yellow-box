-- Yellow Hub Database Schema
-- Database: sq_yellowhk

-- Users table
CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT '',
  `profilePic` varchar(500) DEFAULT '',
  `seo` varchar(255) DEFAULT '',
  `isVerify` tinyint(1) DEFAULT 0,
  `verifyCode` varchar(50) DEFAULT '',
  `createdDate` datetime DEFAULT current_timestamp(),
  `lastLogin` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `email` (`email`),
  KEY `seo` (`seo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Category table
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fcId` int(11) NOT NULL DEFAULT 0,
  `name_tc` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `seo_tc` varchar(255) NOT NULL,
  `seo_en` varchar(255) NOT NULL,
  `displayOrder` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `fcId` (`fcId`),
  KEY `seo_tc` (`seo_tc`),
  KEY `seo_en` (`seo_en`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Product table
CREATE TABLE IF NOT EXISTS `product` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `refId` varchar(20) NOT NULL,
  `fcId` int(11) NOT NULL DEFAULT 0,
  `scId` int(11) NOT NULL DEFAULT 0,
  `listingTitle` varchar(255) NOT NULL,
  `condition` tinyint(1) DEFAULT 0 COMMENT '0=any, 1=brandnew, 2=secondhand',
  `brand` varchar(255) DEFAULT '',
  `price` decimal(10,2) DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `keyword` text DEFAULT NULL,
  `createdDate` datetime DEFAULT current_timestamp(),
  `updatedDate` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `status` tinyint(1) DEFAULT 1 COMMENT '0=deleted, 1=active, 2=sold, 3=reserved',
  `userId` int(11) NOT NULL,
  `viewCount` int(11) DEFAULT 0,
  PRIMARY KEY (`productId`),
  UNIQUE KEY `refId` (`refId`),
  KEY `fcId` (`fcId`),
  KEY `scId` (`scId`),
  KEY `userId` (`userId`),
  KEY `status` (`status`),
  KEY `createdDate` (`createdDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Product Images table
CREATE TABLE IF NOT EXISTS `productImage` (
  `imageId` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `path` varchar(500) NOT NULL,
  `orderId` int(11) DEFAULT 0,
  PRIMARY KEY (`imageId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Favorites table
CREATE TABLE IF NOT EXISTS `favorite` (
  `favoriteId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `createdDate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`favoriteId`),
  UNIQUE KEY `userId_productId` (`userId`, `productId`),
  KEY `userId` (`userId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Message table
CREATE TABLE IF NOT EXISTS `message` (
  `messageId` int(11) NOT NULL AUTO_INCREMENT,
  `fromUserId` int(11) NOT NULL,
  `toUserId` int(11) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '0=unread, 1=read',
  `sentDate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`messageId`),
  KEY `fromUserId` (`fromUserId`),
  KEY `toUserId` (`toUserId`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Saved Searches table (10 limit instead of Carousell's 3)
CREATE TABLE IF NOT EXISTS `saved_search` (
  `searchId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `keyword` varchar(255) DEFAULT '',
  `fcId` int(11) DEFAULT 0,
  `scId` int(11) DEFAULT 0,
  `createdDate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`searchId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default categories
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(0, '電子產品', 'Electronics', '電子產品', 'electronics', 1),
(0, '時尚服飾', 'Fashion', '時尚服飾', 'fashion', 2),
(0, '家居生活', 'Home & Living', '家居生活', 'home-living', 3),
(0, '運動用品', 'Sports', '運動用品', 'sports', 4),
(0, '書籍文具', 'Books & Stationery', '書籍文具', 'books-stationery', 5),
(0, '玩具遊戲', 'Toys & Games', '玩具遊戲', 'toys-games', 6),
(0, '美容健康', 'Beauty & Health', '美容健康', 'beauty-health', 7),
(0, '寵物用品', 'Pet Supplies', '寵物用品', 'pet-supplies', 8),
(0, '門票優惠', 'Tickets & Vouchers', '門票優惠', 'tickets-vouchers', 9),
(0, '其他', 'Others', '其他', 'others', 10);

-- Insert subcategories for Electronics
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(1, '手機', 'Mobile Phones', '手機', 'mobile-phones', 1),
(1, '電腦', 'Computers', '電腦', 'computers', 2),
(1, '相機', 'Cameras', '相機', 'cameras', 3),
(1, '遊戲機', 'Gaming', '遊戲機', 'gaming', 4),
(1, '耳機音響', 'Headphones & Audio', '耳機音響', 'headphones-audio', 5),
(1, '智能手錶', 'Smart Watches', '智能手錶', 'smart-watches', 6);

-- Insert subcategories for Fashion
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(2, '男裝', 'Men''s Fashion', '男裝', 'mens-fashion', 1),
(2, '女裝', 'Women''s Fashion', '女裝', 'womens-fashion', 2),
(2, '手袋', 'Bags', '手袋', 'bags', 3),
(2, '鞋類', 'Shoes', '鞋類', 'shoes', 4),
(2, '手錶', 'Watches', '手錶', 'watches', 5),
(2, '飾物', 'Accessories', '飾物', 'accessories', 6);

-- Insert subcategories for Home & Living
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(3, '傢俬', 'Furniture', '傢俬', 'furniture', 1),
(3, '廚房用品', 'Kitchen', '廚房用品', 'kitchen', 2),
(3, '家電', 'Appliances', '家電', 'appliances', 3),
(3, '裝飾', 'Decor', '裝飾', 'decor', 4);

-- Insert subcategories for Sports
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(4, '健身器材', 'Fitness', '健身器材', 'fitness', 1),
(4, '戶外運動', 'Outdoor', '戶外運動', 'outdoor', 2),
(4, '球類運動', 'Ball Sports', '球類運動', 'ball-sports', 3),
(4, '水上運動', 'Water Sports', '水上運動', 'water-sports', 4);

-- Insert subcategories for Books & Stationery
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(5, '教科書', 'Textbooks', '教科書', 'textbooks', 1),
(5, '小說', 'Fiction', '小說', 'fiction', 2),
(5, '文具', 'Stationery', '文具', 'stationery', 3),
(5, '漫畫', 'Comics', '漫畫', 'comics', 4);

-- Insert subcategories for Toys & Games
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(6, '模型', 'Models', '模型', 'models', 1),
(6, 'Board Games', 'Board Games', 'board-games', 'board-games', 2),
(6, '公仔', 'Plush Toys', '公仔', 'plush-toys', 3),
(6, '兒童玩具', 'Kids Toys', '兒童玩具', 'kids-toys', 4);

-- Insert subcategories for Beauty & Health
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(7, '護膚品', 'Skincare', '護膚品', 'skincare', 1),
(7, '化妝品', 'Cosmetics', '化妝品', 'cosmetics', 2),
(7, '香水', 'Fragrance', '香水', 'fragrance', 3),
(7, '保健食品', 'Health Supplements', '保健食品', 'health-supplements', 4);

-- Insert subcategories for Pet Supplies
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(8, '狗用品', 'Dog Supplies', '狗用品', 'dog-supplies', 1),
(8, '貓用品', 'Cat Supplies', '貓用品', 'cat-supplies', 2),
(8, '寵物食品', 'Pet Food', '寵物食品', 'pet-food', 3),
(8, '其他寵物', 'Other Pets', '其他寵物', 'other-pets', 4);

-- Insert subcategories for Tickets & Vouchers
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(9, '演唱會門票', 'Concert Tickets', '演唱會門票', 'concert-tickets', 1),
(9, '景點門票', 'Attraction Tickets', '景點門票', 'attraction-tickets', 2),
(9, '優惠券', 'Vouchers', '優惠券', 'vouchers', 3),
(9, '現金券', 'Gift Cards', '現金券', 'gift-cards', 4);

-- Insert subcategories for Others
INSERT INTO `category` (`fcId`, `name_tc`, `name_en`, `seo_tc`, `seo_en`, `displayOrder`) VALUES
(10, '免費', 'Free Items', '免費', 'free-items', 1),
(10, '徵求', 'Wanted', '徵求', 'wanted', 2),
(10, '服務', 'Services', '服務', 'services', 3),
(10, '招聘', 'Jobs', '招聘', 'jobs', 4);
