-- MySQL Schema for Capital Charcoal
-- Database: capital_charcoal

CREATE DATABASE IF NOT EXISTS capital_charcoal;
USE capital_charcoal;

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id VARCHAR(255) PRIMARY KEY,
    name_ar TEXT,
    name_en TEXT,
    description_ar TEXT,
    description_en TEXT,
    images LONGTEXT, -- Using LONGTEXT for better compatibility with older MySQL versions
    category VARCHAR(100),
    price VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Articles Table
CREATE TABLE IF NOT EXISTS articles (
    id VARCHAR(255) PRIMARY KEY,
    title_ar TEXT,
    title_en TEXT,
    content_ar TEXT,
    content_en TEXT,
    image TEXT,
    date VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Gallery Table
CREATE TABLE IF NOT EXISTS gallery (
    id VARCHAR(255) PRIMARY KEY,
    url TEXT,
    title_ar TEXT,
    title_en TEXT,
    category VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Reviews Table
CREATE TABLE IF NOT EXISTS reviews (
    id VARCHAR(255) PRIMARY KEY,
    author VARCHAR(255),
    rating INT,
    comment_ar TEXT,
    comment_en TEXT,
    avatar TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inquiries Table
CREATE TABLE IF NOT EXISTS inquiries (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    msg TEXT,
    date VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Settings Table
CREATE TABLE IF NOT EXISTS settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    phone VARCHAR(50),
    whatsapp VARCHAR(50),
    logo TEXT,
    address_ar TEXT,
    address_en TEXT,
    heroTitle_ar TEXT,
    heroTitle_en TEXT,
    heroSub_ar TEXT,
    heroSub_en TEXT,
    heroImage TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default settings if not exists
INSERT INTO settings (id, phone, whatsapp, logo, address_ar, address_en, heroTitle_ar, heroTitle_en, heroSub_ar, heroSub_en, heroImage)
SELECT 1, '01000187892', '201000187892', '', 'دمياط الجديدة', 'New Damietta', 'فحم العاصمة', 'Capital Charcoal', 'جودة لا تضاهى', 'Unmatched Quality', ''
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM settings WHERE id = 1);
