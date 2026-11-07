CREATE DATABASE IF NOT EXISTS db_inventory
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_inventory;

DROP TABLE IF EXISTS transactions, items, categories, users;

-- List of tables
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

-- Insert Data
INSERT INTO users (username, password, full_name, role) VALUES
('admin',   '$2y$12$q0W5sgv.Re6Rysthj6kACOUkB/WtVcwb7RY6KPa09/AfvbRht79pO', 'Administrator', 'admin'),
('staff',   '$2y$12$P8LazVoE5SAgjSjliMK63um9ZG.aYFlRE7Tq7ocVFPKIrX5JBvwZ6', 'Staf Gudang',   'staff'),
('manager', '$2y$12$KjtvsKOoTf/FFSX7A8ihQu5Ls0ah6Rx3K3vJct.x1FUoxv7.iSRSy', 'Manajer',       'manager');

INSERT INTO categories (name, description) VALUES
('Elektronik', 'Perangkat elektronik dan aksesori'),
('Alat Tulis', 'Perlengkapan tulis dan kertas'),
('Furnitur', 'Meja, kursi, dan lemari'),
('Perlengkapan Kebersihan', 'Alat dan bahan kebersihan');

INSERT INTO items (code, name, category_id, quantity, unit, price, entry_date, description) VALUES
('ITM0001', 'Laptop Lenovo ThinkPad', 1, 8, 'unit', 12500000, '2026-10-01', 'Laptop kerja'),
('ITM0002', 'Mouse Wireless', 1, 25, 'pcs', 85000, '2026-10-02', NULL),
('ITM0003', 'Keyboard Mekanik', 1, 4, 'pcs', 450000, '2026-10-03', NULL),
('ITM0004', 'Monitor 24 inci', 1, 10, 'unit', 1800000, '2026-10-05', NULL),
('ITM0005', 'Pulpen Hitam', 2, 120, 'pcs', 3500, '2026-10-06', NULL),
('ITM0006', 'Kertas A4 80gr', 2, 3, 'rim', 55000, '2026-10-07', NULL),
('ITM0007', 'Buku Tulis', 2, 60, 'pcs', 6000, '2026-10-08', NULL),
('ITM0008', 'Meja Kerja', 3, 6, 'unit', 1200000, '2026-10-10', NULL),
('ITM0009', 'Kursi Kantor', 3, 5, 'unit', 850000, '2026-10-11', NULL),
('ITM0010', 'Lemari Arsip', 3, 2, 'unit', 2100000, '2026-10-12', NULL),
('ITM0011', 'Sapu', 4, 15, 'pcs', 25000, '2026-10-15', NULL),
('ITM0012', 'Cairan Pel', 4, 9, 'botol', 18000, '2026-10-16', NULL);

INSERT INTO transactions (item_id, user_id, type, quantity, notes) VALUES
(1, 1, 'IN',  5,  'Restock awal'),
(2, 2, 'OUT', 3,  'Dipakai tim'),
(5, 2, 'IN',  50, 'Pembelian bulanan'),
(6, 3, 'OUT', 2,  'Kebutuhan kantor');