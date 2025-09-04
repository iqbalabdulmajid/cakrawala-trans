<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// === KELOMPOK CONTROLLER USER ===
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\CarController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\LandingController;
use App\Http\Controllers\User\PaymentController;

// === KELOMPOK CONTROLLER ADMIN ===
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CarController as AdminCarController; // Alias untuk hindari konflik nama kelas
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE UNTUK HALAMAN PUBLIK (USER) ---
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/mobil', [CarController::class, 'index'])->name('car');
Route::get('/mobil/{id}', [CarController::class, 'show'])->name('cars.show');
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');

// --- RUTE OTENTIKASI (LOGIN, REGISTER, LOGOUT, DLL) ---
// Perintah ini mendaftarkan semua rute yang diperlukan untuk otentikasi.
Auth::routes();

// --- RUTE YANG MEMBUTUHKAN LOGIN ---
Route::middleware(['auth'])->group(function () {
    // Rute untuk proses pemesanan (menggunakan method POST)
    Route::get('/booking/create/{car}', [\App\Http\Controllers\User\BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // Rute untuk halaman pembayaran
    Route::get('/payment/{booking}', [PaymentController::class, 'show'])->name('payment.show');
    Route::get('/riwayat-pesanan', [BookingController::class, 'index'])->name('booking.index');
     Route::get('/jadwal-ketersediaan', [\App\Http\Controllers\User\ScheduleController::class, 'index'])->name('schedule.index');
});


// --- RUTE UNTUK ADMIN (DENGAN PENJAGA) ---
Route::prefix('admin')
    ->name('admin.')
    // Middleware 'auth' memastikan hanya user yang sudah login bisa masuk.
    // Middleware 'admin' (yang kita buat sebelumnya) memastikan hanya user dengan role 'admin' bisa masuk.
    ->middleware(['auth', 'admin'])
    ->group(function () {

    // URL: /admin/dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // URL: /admin/mobil, /admin/mobil/create, dll.
    Route::resource('mobil', AdminCarController::class);

    // URL: /admin/pemesanan
    Route::get('/pemesanan', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/pemesanan/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::put('/pemesanan/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    // URL: /admin/laporan
    Route::get('/laporan', [AdminReportController::class, 'index'])->name('reports.index');
    Route::post('/mobil/sync', [AdminCarController::class, 'syncApi'])->name('mobil.sync');

});

// Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification'])->name('midtrans.notification');
Route::post('/api/midtrans/webhook', [PaymentController::class, 'handleNotification']);


