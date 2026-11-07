# Repositori Pemrograman Web

Repositori ini berisi kumpulan materi, latihan, tugas, dan proyek praktikum mata kuliah **Pemrograman Web**. Materi disusun secara bertahap mulai dari dasar-dasar HTML hingga pengembangan aplikasi web dinamis berbasis arsitektur MVC (Model-View-Controller) menggunakan PHP dan database MySQL.

---

## 📚 Ringkasan Materi Tiap Pertemuan

### 🔹 [Pertemuan 01: Pengenalan Dasar HTML](file:///M:/Temp/pemrograman-web-m/pertemuan-01)
Fokus pada pemahaman struktur dasar dokumen web (*HyperText Markup Language*):
- **Struktur Dokumen**: Tag dasar HTML (`<head>`, `<title>`, `<body>`, dsb.).
- **Elemen Teks & Multimedia**: Heading (`<h1>`), paragraf (`<p>`), penyisipan gambar (`<img>`), dan pengaturan layout/tampilan dasar inline CSS.
- **Navigasi Hyperlink**: Menghubungkan halaman menggunakan tag anchor (`<a>`) untuk navigasi antarhalaman (`index.html` ke `page2.html`).

---

### 🔹 [Pertemuan 02: Perancangan Antarmuka Web dengan Bootstrap 5](file:///M:/Temp/pemrograman-web-m/pertemuan-02)
Fokus pada perancangan tampilan web modern, responsif, dan interaktif menggunakan framework CSS **Bootstrap 5**:
- **Komponen UI**: Pemanfaatan navbar navigasi (`navbar`), dropdown menu, form input, dan card layout.
- **Halaman Prototipe**:
  - `index.html`: Desain form autentikasi (login/masuk & registrasi) Sistem Informasi Manajemen.
  - `home.html` & `dashboard.html`: Antarmuka dashboard sistem informasi yang responsif dengan komponen card statistik dan navigasi sidebar.

---

### 🔹 [Pertemuan 03: Logika Pemrograman & Kontrol Alur PHP](file:///M:/Temp/pemrograman-web-m/pertemuan-03)
Fokus pada fundamental backend scripting menggunakan bahasa **PHP**, mencakup struktur kontrol logika dan perulangan (*control flow*):
- **Percabangan (Conditional Statements)**:
  - `01_if.php`, `02_if_else.php`, `03_else_if.php`: Percabangan logika bertingkat.
  - `04_nested_if.php`: Percabangan bersarang (*nested condition*).
  - `05_switch.php` & `06_match.php`: Struktur multi-kondisi termasuk sintaks modern `match` PHP 8.
  - `07_ternary.php`: Operator ternary untuk evaluasi kondisi ringkas.
- **Perulangan (Loops)**:
  - `08_for.php`, `09_while.php`, `10_do_while.php`: Dasar iterasi berulang.
  - `11_foreach.php`: Iterasi struktur data array.
  - `12_break_continue.php`: Pengontrol alur loop.
- **Implementasi & Kasus**:
  - `13_alt_syntax.php`: Alternatif penulisan sintaks PHP untuk integrasi template HTML.
  - `14_studi_kasus.php` & `15_studi_kasus_tabel.php`: Penerapan logika logika percabangan dan perulangan untuk menampilkan data dinamis ke dalam tabel HTML.

---

### 🔹 [Pertemuan 04: Aplikasi Inventaris Barang (Arsitektur PHP MVC)](file:///M:/Temp/pemrograman-web-m/pertemuan-04/inventaris-mvc)
Fokus pada pengembangan aplikasi web terstruktur berskala penuh tanpa framework (*native MVC*), mengintegrasikan PHP 8, Database MySQL, PDO, dan Bootstrap 5:
- **Arsitektur Model-View-Controller (MVC)**: Pemisahan logika aplikasi (Controllers), representasi data dan database (Models), serta tampilan antarmuka (Views).
- **Manajemen Basis Data & Transaksi**:
  - Koneksi aman menggunakan PDO (*PHP Data Objects*).
  - Integritas data stok masuk/keluar menggunakan *Database Transactions* (`beginTransaction`, `commit`, `rollBack`).
- **Fitur Utama**:
  - Sistem Autentikasi & Otorisasi multi-peran berbasis session (`admin`, `staff`, `manager`).
  - Operasi CRUD (*Create, Read, Update, Delete*) Kategori dan Barang.
  - Transaksi mutasi stok barang (masuk/keluar).
  - Fitur pencarian, filter data, paginasi, serta ringkasan dashboard analitik.

---

## 🛠️ Persyaratan Lingkungan Pengembangan

- **Web Server / PHP**: PHP >= 8.0 (atau paket web server seperti XAMPP / Laragon)
- **Database**: MySQL / MariaDB
- **Web Browser**: Google Chrome, Mozilla Firefox, Microsoft Edge, dsb.
- **Code Editor**: Visual Studio Code atau sejenisnya

---

## 🚀 Panduan Menjalankan Proyek

### 1. Menjalankan Pertemuan 01 - 03
- Untuk file statis HTML (Pertemuan 01 & 02), Anda dapat langsung membuka file `.html` di peramban (browser) atau menggunakan ekstensi *Live Server*.
- Untuk skrip PHP (Pertemuan 03), jalankan melalui local development server bawaan PHP:
  ```bash
  cd pertemuan-03
  php -S localhost:8000
  ```
  Kemudian akses skrip yang diinginkan di browser, misalnya: `http://localhost:8000/15_studi_kasus_tabel.php`.

### 2. Menjalankan Proyek MVC (Pertemuan 04)
1. Masuk ke direktori proyek:
   ```bash
   cd pertemuan-04/inventaris-mvc
   ```
2. Salin konfigurasi environment:
   ```bash
   copy .env.example .env
   ```
   *Sesuaikan konfigurasi database `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PASS` pada `.env`.*
3. Impor skema dan seed data awal ke MySQL:
   ```bash
   mysql -u root -p < database/inventory.sql
   ```
4. Jalankan local server PHP:
   ```bash
   php -S localhost:8000 -t public public/index.php
   ```
5. Akses aplikasi melalui web browser di `http://localhost:8000`.

---

## 👤 Akun Percobaan (Pertemuan 04)

| Role | Username | Password |
|---|---|---|
| **Admin** | `admin` | `123` |
| **Staff** | `staff` | `1234` |
| **Manager** | `manager` | `12345` |

