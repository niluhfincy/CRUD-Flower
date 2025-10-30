# 💐 Aplikasi Manajemen Toko Bunga (Florist CRUD)

Aplikasi CRUD (Create, Read, Update, Delete) untuk mengelola katalog bunga di toko bunga, dibangun dengan PHP native dan database MySQL.

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

## 📚 Kebutuhan Sistem

- PHP 8.0 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web server (Apache, Nginx, dll.)
- Koneksi internet (untuk mengambil gambar dari URL dan Bootstrap CDN)

## 👩🏻‍💻 Cara Instalasi dan Konfigurasi

🧩 Langkah 1: Kloning dan Penempatan File
Letakkan folder florist-crud ke dalam direktori server:
htdocs → jika menggunakan XAMPP
www → jika menggunakan Laragon
Jalankan Apache dan MySQL.

🧩 Langkah 2: Konfigurasi Database
Buat database baru:

CREATE DATABASE db_daribontang;
