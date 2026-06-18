-- Migration 002: Purchase intent, ratings and reviews system
-- Run: mysql --host=localhost --user=root --password=root sq_yellowhk < query/migration_002.sql

-- Purchase intent table (when buyer clicks "Confirm Purchase")
CREATE TABLE IF NOT EXISTS purchase_intent (
  intentId INT AUTO_INCREMENT PRIMARY KEY,
  productId INT NOT NULL,
  buyerId INT NOT NULL,
  sellerId INT NOT NULL,
  status VARCHAR(20) DEFAULT 'pending' COMMENT 'pending, confirmed, completed, cancelled',
  createdDate DATETIME NOT NULL,
  confirmedDate DATETIME DEFAULT NULL,
  completedDate DATETIME DEFAULT NULL,
  INDEX idx_product (productId),
  INDEX idx_buyer (buyerId),
  INDEX idx_seller (sellerId),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Reviews/Ratings table
CREATE TABLE IF NOT EXISTS review (
  reviewId INT AUTO_INCREMENT PRIMARY KEY,
  productId INT NOT NULL,
  fromUserId INT NOT NULL,
  toUserId INT NOT NULL,
  intentId INT NOT NULL,
  rating INT NOT NULL DEFAULT 5 COMMENT '1-5 stars',
  comment TEXT DEFAULT NULL,
  createdDate DATETIME NOT NULL,
  UNIQUE KEY unique_review (intentId, fromUserId),
  INDEX idx_product (productId),
  INDEX idx_fromUser (fromUserId),
  INDEX idx_toUser (toUserId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add rating columns to user table
ALTER TABLE user ADD COLUMN ratingAvg DECIMAL(3,2) DEFAULT 0.00 AFTER responseRate;
ALTER TABLE user ADD COLUMN ratingCount INT DEFAULT 0 AFTER ratingAvg;
