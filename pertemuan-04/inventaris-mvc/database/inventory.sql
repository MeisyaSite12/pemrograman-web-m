CREATE DATABASE IF NOT EXISTS db_inventory
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_inventory;

DROP TABLE IF EXISTS transactions, items, categories, users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  full_name VARCHAR(100),
  role ENUM('admin','staff','manager') NOT NULL DEFAULT 'staff',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(20) NOT NULL UNIQUE,
  name VARCHAR(150) NOT NULL,
  category_id INT NULL,
  quantity INT NOT NULL DEFAULT 0,
  unit VARCHAR(20) NOT NULL DEFAULT 'unit',
  price DECIMAL(15,2) NOT NULL DEFAULT 0,
  entry_date DATE NULL,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_items_category FOREIGN KEY (category_id)
    REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_id INT NOT NULL,
  user_id INT NOT NULL,
  type ENUM('IN','OUT') NOT NULL,
  quantity INT NOT NULL,
  notes VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_transactions_item FOREIGN KEY (item_id)
    REFERENCES items(id) ON DELETE CASCADE,
  CONSTRAINT fk_transactions_user FOREIGN KEY (user_id)
    REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categories (name, description) VALUES
('Elektronik', 'Perangkat elektronik dan aksesori'),
('Alat Tulis', 'Perlengkapan tulis dan kantor'),
('Furnitur', 'Meja, kursi, dan lemari'),
('Jaringan', 'Perangkat jaringan dan kabel');

INSERT INTO items (code, name, category_id, quantity, unit, price, entry_date, description) VALUES
('ITM0001', 'Laptop Asus', 1, 10, 'unit', 12500000, '2026-01-10', 'Laptop kantor'),
('ITM0002', 'Mouse Wireless', 1, 25, 'pcs', 150000, '2026-01-12', NULL),
('ITM0003', 'Keyboard Mekanik', 1, 4, 'pcs', 450000, '2026-01-15', NULL),
('ITM0004', 'Kertas A4', 2, 50, 'rim', 55000, '2026-02-01', NULL),
('ITM0005', 'Pulpen', 2, 3, 'box', 40000, '2026-02-03', NULL),
('ITM0006', 'Meja Kerja', 3, 8, 'unit', 1200000, '2026-02-10', NULL),
('ITM0007', 'Kursi Kantor', 3, 12, 'unit', 850000, '2026-02-10', NULL),
('ITM0008', 'Router WiFi', 4, 6, 'unit', 650000, '2026-03-01', NULL),
('ITM0009', 'Kabel LAN 10m', 4, 2, 'pcs', 45000, '2026-03-02', NULL);

INSERT INTO users (username, password, full_name, role) VALUES
('admin', '$2y$12$xjqJPPxYxpPuHyfMBQDz1.ZiTzHnWm4bbItc6KJ2krEOJlQColPh2', 'Administrator', 'admin');