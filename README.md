<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Cakrawala Trans - Aplikasi Web Rental Mobil
Deskripsi Singkat
Cakrawala Trans adalah aplikasi web penyewaan mobil modern yang dibangun menggunakan Laravel. Aplikasi ini dirancang untuk memberikan kemudahan bagi pelanggan dalam mencari, memesan, dan membayar sewa mobil secara online. Untuk admin, aplikasi ini menyediakan dashboard yang komprehensif untuk mengelola inventaris mobil, memantau pesanan, dan melihat laporan.

Fitur unggulan dari aplikasi ini adalah implementasi Optical Character Recognition (OCR) menggunakan Tesseract.js yang memungkinkan pengguna mengunggah foto KTP mereka, dan sistem secara otomatis akan mengisi data NIK dan Nama Lengkap, mempercepat proses pemesanan dan mengurangi kesalahan input manual.

Fitur Utama
Untuk Pelanggan (User)
Pendaftaran & Login: Sistem autentikasi untuk pengguna.

Katalog Mobil: Menampilkan daftar model mobil yang tersedia, dikelompokkan berdasarkan model dengan informasi stok (Sisa 3 dari 4 unit).

Detail Mobil: Halaman detail untuk setiap mobil yang menampilkan spesifikasi, harga, stok tersedia, dan informasi ketersediaan sopir.

Sistem Pemesanan: Form pemesanan dengan validasi, pilihan tanggal dan jam sewa, serta upload dokumen (KTP & SIM).

Fitur OCR Otomatis: Mengisi NIK dan Nama secara otomatis dengan membaca gambar KTP yang diunggah pengguna, berjalan sepenuhnya di browser (client-side).

Pembayaran Online: Integrasi dengan payment gateway Midtrans untuk proses pembayaran yang aman.

Riwayat Pesanan: Halaman untuk melihat status dan detail semua pesanan yang pernah dibuat.

Untuk Administrator
Dashboard Admin: Menampilkan statistik kunci seperti total pendapatan, jumlah pesanan, dan jumlah pelanggan.

Manajemen Inventaris (CRUD): Tambah, lihat, edit, dan hapus data mobil.

Manajemen Pesanan: Melihat semua pesanan yang masuk, memfilter, dan mengubah statusnya (Pending, Confirmed, Completed, Cancelled).

Checklist Pengembalian: Form checklist kondisi kendaraan (body, interior, ban, dokumen) yang diisi oleh admin saat mobil dikembalikan untuk menyelesaikan pesanan.

Verifikasi Dokumen: Melihat foto KTP dan SIM yang diunggah oleh pelanggan.

Teknologi yang Digunakan
Backend: PHP 8.x, Laravel 10.x

Frontend: HTML, CSS, JavaScript, Blade Templating

Database: MySQL / MariaDB

Payment Gateway: Midtrans (Snap.js)

OCR Engine: Tesseract.js (berjalan di sisi klien/browser)

Server Lokal: Laragon (XAMPP/MAMPP juga bisa digunakan)

Panduan Instalasi (Lokal)
Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda.

Prasyarat:

PHP >= 8.1

Composer

Node.js & NPM

Web Server Lokal (Contoh: Laragon)

Clone Repository:

git clone [https://github.com/username-anda/cakrawala-trans-app.git](https://github.com/username-anda/cakrawala-trans-app.git)
cd cakrawala-trans-app

Install Dependencies:

composer install
npm install
npm run dev

Setup Environment File:

Salin file .env.example menjadi .env.

Jalankan perintah ini untuk membuat kunci aplikasi:

php artisan key:generate

Konfigurasi koneksi database Anda (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

Masukkan kunci Midtrans Anda:

MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false

Migrasi & Seeding Database:
Jalankan perintah ini untuk membuat semua tabel dan mengisinya dengan data contoh (termasuk user admin).

php artisan migrate:fresh --seed

Akun Admin Default: admin@example.com / password

Akun User Default: user@example.com / password

Storage Link:
Buat symbolic link agar file yang di-upload (gambar mobil, KTP, SIM) bisa diakses dari web.

php artisan storage:link

Jalankan Server:

php artisan serve

Aplikasi Anda sekarang bisa diakses di http://127.0.0.1:8000.

Catatan Penting
Pengujian Pembayaran Midtrans (Lokal)
Untuk menguji notifikasi pembayaran (webhook) dari Midtrans di lingkungan lokal, Anda wajib menggunakan layanan tunneling seperti Ngrok.

Jalankan ngrok http 8000 dan masukkan URL https yang diberikan ke Payment Notification URL di dashboard Midtrans Anda, dengan path: https://<url-ngrok-anda>/api/midtrans/webhook.

Saat aplikasi sudah di-hosting, Anda tidak perlu lagi menggunakan Ngrok. Cukup gunakan URL domain asli Anda.

Implementasi OCR
Fitur OCR untuk membaca KTP berjalan 100% di sisi klien (browser) menggunakan Tesseract.js.

Ini berarti Anda tidak perlu menginstal Tesseract OCR di komputer lokal atau server hosting. Cukup koneksi internet bagi pengguna untuk mengunduh file bahasa saat pertama kali digunakan.
