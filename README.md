# 💐 Aplikasi Manajemen Toko Bunga (Florist CRUD)

Aplikasi CRUD (Create, Read, Update, Delete) untuk mengelola katalog bunga di toko bunga, dibangun dengan PHP native dan database MySQL.

---

## ⚙️ Fitur

- **Create**: Menambahkan bunga baru ke katalog dengan informasi lengkap (nama, harga, stok, deskripsi, gambar, dll.).
- **Read**: Menampilkan katalog bunga dalam bentuk kartu yang menarik.
- **View Detail**: Melihat informasi detail dan gambar setiap bunga.
- **Update**: Mengubah informasi bunga yang sudah ada.
- **Delete**: Menghapus bunga dari katalog dengan konfirmasi.
- **Pencarian**: Mencari bunga berdasarkan nama atau nama latin.
- **Filter Kategori**: Menyaring bunga berdasarkan kategori (Bunga Potong, Tanaman Hias, dll.).
- **Pagination**: Membatasi jumlah data per halaman (6 item per halaman).
- **Validasi dan Sanitasi**: Validasi sisi server dan sanitasi data untuk keamanan.
- **Keamanan**: Perlindungan terhadap SQL Injection dan XSS.
- **Desain Responsif**: Tampilan yang menarik dan dapat diakses di berbagai perangkat.

---

## 📚 Kebutuhan Sistem

- PHP 8.0 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web server (Apache, Nginx, dll.)
- Koneksi internet (untuk mengambil gambar dari URL dan Bootstrap CDN)

---

## 👩🏻‍💻 Cara Instalasi dan Konfigurasi

### 🧩 Langkah 1: Kloning dan Penempatan File
Letakkan folder florist-crud ke dalam direktori server:

htdocs → jika menggunakan XAMPP
www → jika menggunakan Laragon
Jalankan Apache dan MySQL.

### 🧩 Langkah 2: Konfigurasi Database
1. Buat database baru:

````
CREATE DATABASE florist_shop;

2. Buka file config/database.php. Sesuaikan konfigurasi:

    private $host = 'localhost';
    private $db_name = 'florist_shop';
    private $username = 'root';
    private $password = '';
    private $conn;

3. Jalankan query SQL berikut untuk membuat tabel:

CREATE TABLE IF NOT EXISTS flowers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    latin_name VARCHAR(100),
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    description TEXT,
    image_url VARCHAR(255),
    category ENUM('Bunga Potong', 'Tanaman Hias', 'Buket', 'Karangan Bunga') NOT NULL,
    color VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert some sample data
INSERT INTO flowers (name, latin_name, price, stock, description, image_url, category, color) VALUES
('Mawar Merah', 'Rosa rubiginosa', 75000, 50, 'Simbol cinta dan kasih sayang, mawar merah klasik sempurna untuk berbagai occasions.', 'https://images.unsplash.com/photo-1518709594023-cce4d510b697?w=500', 'Bunga Potong', 'Merah'),
('Anggrek Bulan', 'Phalaenopsis amabilis', 120000, 30, 'Bunga nasional Indonesia yang elegan dengan daya tahan lama dan keindahan yang memukau.', 'https://images.unsplash.com/photo-1530103834929-0c5f98b15221?w=500', 'Tanaman Hias', 'Putih'),
('Lily Putih', 'Lilium candidum', 85000, 25, 'Melambangkan kesucian dan keanggunan, lily putih menambah sentuhan kemewahan pada rangkaian bunga.', 'https://images.unsplash.com/photo-1599424256974-3e250e7173a4?w=500', 'Bunga Potong', 'Putih'),
('Buket Pengantin', 'Mixed Bouquet', 350000, 10, 'Buket eksklusif campuran mawar, lily, dan baby breath yang dirangkai khusus untuk hari istimewa Anda.', 'https://images.unsplash.com/photo-1561181286-d5e66d0a9a53?w=500', 'Buket', 'Campuran'),
('Tulip Kuning', 'Tulipa gesneriana', 65000, 40, 'Melambangkan kebahagiaan dan persahabatan, tulip kuning ceria menyegarkan ruangan mana pun.', 'https://images.unsplash.com/photo-1589256970683-2f23c1b6f6c7?w=500', 'Bunga Potong', 'Kuning'),
('Karangan Bunga Duka', 'Standing Wreath', 500000, 5, 'Karangan bunga standing elegan untuk mengungkapkan belasungkawa dengan penuh penghormatan.', 'https://images.unsplash.com/photo-1606090958453-9e4ed226f503?w=500', 'Karangan Bunga', 'Putih');
````

### 🧩 Langkah 3: Akses Aplikasi di browser
http://localhost/florist-crud

---
## 📂 Struktur Folder

```
florist-crud/
├── assets/
│ ├── css/
│ │ └── style.css
│ └── images/
│ └── screenshot.png
├── config/
│ └── database.php
├── includes/
│ ├── functions.php
│ ├── header.php
│ └── footer.php
├── pages/
│ ├── create.php
│ ├── edit.php
│ ├── view.php
│ └── delete.php
├── .env.example
├── README.md
├── index.php

````
---

## 🧾 Contoh Environment Config

Jika ingin menggunakan file `.env` sebagai pengganti `config/database.php`, buat file baru bernama `.env` di folder utama:

```env
# Konfigurasi Database
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=florist_shop
DB_USERNAME=root
DB_PASSWORD=

# Pengaturan Aplikasi
APP_NAME="Florist Shop"
APP_URL=http://localhost/florist-crud
APP_ENV=local
APP_DEBUG=true
```

## 🖼️ Screenshot Aplikasi

### 🏠 Beranda/Katalog
<img width="1469" height="1286" alt="Screenshot 2025-10-30 194028" src="https://github.com/user-attachments/assets/0e0af46c-4901-4343-965e-00ab46662399" />

### ➕ Tambah Bunga Baru
<img width="2879" height="1508" alt="Screenshot 2025-10-30 194337" src="https://github.com/user-attachments/assets/5453784b-36b4-41f6-a1f6-46da9d1afc10" />

### 👁️Melihat Detail Bunga
<img width="1880" height="1456" alt="Screenshot 2025-10-30 194436" src="https://github.com/user-attachments/assets/c65d4a4e-d23e-44ee-9bfb-c208d75c633d" />
