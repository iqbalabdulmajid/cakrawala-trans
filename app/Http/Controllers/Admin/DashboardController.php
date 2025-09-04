<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking; // <-- IMPORT MODEL BOOKING
use App\Models\Car;     // <-- IMPORT MODEL CAR
use App\Models\User;    // <-- IMPORT MODEL USER
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk Admin.
     */
    public function index()
    {
        // 1. Ambil data dari database menggunakan Model
        $jumlahMobil = Car::count();
        $jumlahUser = User::where('role', 'user')->count(); // Hanya hitung yang rolenya 'user'
        $jumlahBooking = Booking::count();

        // 2. Kirim data tersebut ke view menggunakan 'compact'
        return view('admin.dashboard.index', compact('jumlahMobil', 'jumlahUser', 'jumlahBooking'));
    }
}
