Aplikasi Rental Mobil - Cakrawala Trans Group (Skripsi)
Ini adalah aplikasi web untuk manajemen dan pemesanan rental mobil, dikembangkan sebagai bagian dari penelitian skripsi. Aplikasi ini dibangun menggunakan framework Laravel 11 untuk sistem utama dan layanan mikro Python/Flask untuk fitur rekomendasi mobil berbasis K-Nearest Neighbors (KNN).

Prasyarat
Sebelum memulai, pastikan Anda sudah menginstal perangkat lunak berikut di sistem Anda:

PHP (versi 8.2 atau lebih baru)

Composer (Dependency Manager untuk PHP)

Node.js dan npm (untuk instalasi laravel/ui jika diperlukan)

Python (versi 3.8 atau lebih baru)

Pip (Package Installer untuk Python)

Database Server (misalnya MySQL via Laragon, XAMPP, dll.)

Panduan Instalasi
Proses instalasi dibagi menjadi dua bagian: Aplikasi Utama (Laravel) dan API Rekomendasi (Python). Pastikan Anda sudah berada di dalam direktori utama proyek sebelum memulai.

Bagian 1: Instalasi Aplikasi Utama (Laravel)
Install Dependencies PHP
Buka terminal di direktori proyek dan jalankan Composer untuk menginstal semua library PHP yang dibutuhkan.

composer install

Siapkan File Environment
Salin file .env.example menjadi .env. File ini akan menyimpan semua konfigurasi proyek Anda.

copy .env.example .env

(Untuk Windows)

cp .env.example .env

(Untuk macOS/Linux)

Generate Kunci Aplikasi
Buat kunci enkripsi unik untuk aplikasi Anda.

php artisan key:generate

Konfigurasi Database
Buka file .env dan sesuaikan pengaturan database Anda.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cakrawala_trans_db
DB_USERNAME=root
DB_PASSWORD=

Jangan lupa untuk membuat database bernama cakrawala_trans_db di manajer database Anda (misalnya phpMyAdmin).

Jalankan Migrasi dan Seeder
Perintah ini akan membuat semua tabel di database Anda dan mengisinya dengan data awal (termasuk akun admin).

php artisan migrate:fresh --seed

Buat Storage Link
Perintah ini penting untuk memastikan gambar yang di-upload bisa diakses dari browser.

php artisan storage:link

Bagian 2: Instalasi API Rekomendasi (Python/Flask)
Navigasi ke Direktori API
Dari direktori utama proyek, masuk ke folder API Python.

cd python # atau nama folder API Anda

Buat Virtual Environment
Sangat disarankan untuk membuat lingkungan virtual agar library Python tidak tercampur.

python -m venv venv

Aktifkan Virtual Environment

# Untuk Windows
venv\Scripts\activate

# Untuk macOS/Linux
source venv/bin/activate

Anda akan melihat (venv) di awal baris terminal Anda.

Install Dependencies Python
Install semua library Python yang dibutuhkan oleh API.

pip install Flask pandas scikit-learn

Menjalankan Aplikasi
Untuk menjalankan aplikasi secara penuh, Anda perlu menjalankan dua server secara bersamaan di dua terminal terpisah.

Terminal 1: Jalankan Server Laravel
Di direktori utama proyek, jalankan:

php artisan serve

Aplikasi utama akan berjalan di http://127.0.0.1:8000.

Terminal 2: Jalankan Server API Python
Pastikan virtual environment sudah aktif. Di dalam direktori API (python/), jalankan:

python app.py

API rekomendasi akan berjalan di http://127.0.0.1:5001.

Sinkronisasi Data Awal
Setelah kedua server berjalan, lakukan langkah ini satu kali:

Buka browser dan login sebagai admin.

Masuk ke halaman Manajemen Mobil.

Klik tombol "Sync Data ke API". Ini akan mengirim semua data mobil dari database Laravel ke API Python agar model KNN bisa dilatih.

Akun Default
Anda bisa login ke sistem menggunakan akun admin yang sudah dibuat oleh seeder:

Email: admin@cakrawala.com

Password: password123

Aplikasi Anda sekarang siap untuk digunakan!
