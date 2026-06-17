-- Migration 001: Add new features tables and columns
-- Run this file manually: mysql --host=localhost --user=root --password=root sq_yellowhk < query/migration_001.sql

-- Add new columns to existing tables
ALTER TABLE product ADD COLUMN viewCount INT DEFAULT 0 AFTER status;
ALTER TABLE product ADD COLUMN isSold INT DEFAULT 0 AFTER viewCount;
ALTER TABLE user ADD COLUMN lastActive DATETIME DEFAULT NULL AFTER phone;
ALTER TABLE user ADD COLUMN responseTime VARCHAR(50) DEFAULT NULL AFTER lastActive;
ALTER TABLE user ADD COLUMN responseRate INT DEFAULT 0 AFTER responseTime;

-- Product view tracking
CREATE TABLE IF NOT EXISTS product_view (
  viewId INT AUTO_INCREMENT PRIMARY KEY,
  productId INT NOT NULL,
  userId INT DEFAULT NULL,
  ipAddress VARCHAR(45) DEFAULT NULL,
  viewedDate DATETIME NOT NULL,
  INDEX idx_product (productId),
  INDEX idx_user (userId),
  INDEX idx_date (viewedDate)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- User follow system
CREATE TABLE IF NOT EXISTS user_follow (
  followId INT AUTO_INCREMENT PRIMARY KEY,
  followerId INT NOT NULL,
  followingId INT NOT NULL,
  createdDate DATETIME NOT NULL,
  UNIQUE KEY unique_follow (followerId, followingId),
  INDEX idx_follower (followerId),
  INDEX idx_following (followingId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- User block system
CREATE TABLE IF NOT EXISTS user_block (
  blockId INT AUTO_INCREMENT PRIMARY KEY,
  userId INT NOT NULL,
  blockedUserId INT NOT NULL,
  createdDate DATETIME NOT NULL,
  UNIQUE KEY unique_block (userId, blockedUserId),
  INDEX idx_user (userId),
  INDEX idx_blocked (blockedUserId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Product reporting
CREATE TABLE IF NOT EXISTS product_report (
  reportId INT AUTO_INCREMENT PRIMARY KEY,
  productId INT NOT NULL,
  userId INT NOT NULL,
  reason VARCHAR(500) NOT NULL,
  status INT DEFAULT 0,
  createdDate DATETIME NOT NULL,
  INDEX idx_product (productId),
  INDEX idx_user (userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Notifications
CREATE TABLE IF NOT EXISTS notification (
  notificationId INT AUTO_INCREMENT PRIMARY KEY,
  userId INT NOT NULL,
  type VARCHAR(50) NOT NULL,
  message TEXT NOT NULL,
  relatedId INT DEFAULT NULL,
  isRead INT DEFAULT 0,
  createdDate DATETIME NOT NULL,
  INDEX idx_user (userId),
  INDEX idx_read (isRead)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Search history (unlimited storage)
CREATE TABLE IF NOT EXISTS search_history (
  historyId INT AUTO_INCREMENT PRIMARY KEY,
  userId INT NOT NULL,
  keyword VARCHAR(200) NOT NULL,
  createdDate DATETIME NOT NULL,
  INDEX idx_user (userId),
  INDEX idx_date (createdDate)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
