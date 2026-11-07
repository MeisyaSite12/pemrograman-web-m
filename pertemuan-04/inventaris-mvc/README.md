# Sistem Inventaris Barang (PHP MVC)

Aplikasi inventaris tanpa framework: PHP 8, MySQL/MariaDB, PDO, Bootstrap 5.

## Instalasi
1. Salin `.env.example` menjadi `.env`, sesuaikan DB_HOST, DB_PORT, DB_USER, DB_PASS.
2. Impor database: `mysql -u root -p < database/inventory.sql`
3. Jalankan: `php -S localhost:8000 -t public public/index.php`
4. Buka http://localhost:8000

## Akun Demo
| Username | Password | Role  |
|----------|----------|-------|
| admin    | 123      | admin |
| staff    | 1234     | staff |
| manager  | 12345    |manager|

## Fitur
CRUD kategori dan barang, transaksi stok masuk/keluar (DB transaction),
login berbasis session, pencarian, filter, paginasi, dashboard.