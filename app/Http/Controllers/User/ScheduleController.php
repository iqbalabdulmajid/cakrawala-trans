<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Menampilkan halaman jadwal ketersediaan semua mobil.
     */
    public function index()
    {
        // Ambil SEMUA mobil, tidak peduli statusnya.
        // Kita juga memuat relasi 'bookings' untuk setiap mobil,
        // tapi hanya booking yang statusnya 'confirmed' dan belum selesai.
        $cars = Car::with(['bookings' => function ($query) {
            $query->where('status', 'confirmed')
                  ->where('end_date', '>=', now()) // Hanya ambil pesanan yang masih aktif
                  ->orderBy('end_date', 'asc'); // Urutkan agar yang paling cepat kembali muncul pertama
        }])->get();

        // Kirim data mobil ke view
        return view('user.schedule.index', compact('cars'));
    }
}
