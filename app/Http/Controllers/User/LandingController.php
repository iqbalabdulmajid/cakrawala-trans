<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Untuk memanggil API

class LandingController extends Controller
{
    /**
     * Menampilkan halaman utama dengan daftar mobil yang bisa disewa.
     * Sesuai "Use Case Pencarian dan Pemesanan Mobil".
     */
    public function index(Request $request)
    {
        // --- Bagian untuk mengisi dropdown di form ---
        // Ambil semua merek dan model unik dari database untuk ditampilkan di filter
        $allBrands = Car::query()->distinct()->pluck('brand');
        $allModels = Car::query()->distinct()->pluck('model');

        // --- Bagian untuk memanggil API KNN ---
        $recommendedCars = [];
        $apiBaseUrl = 'http://127.0.0.1:5001/api/recommend';

        // Ambil semua input dari form filter yang ada di request
        $queryParams = $request->only(['brand', 'model', 'year', 'rental_price']);

        try {
            // Kirim request ke API Flask dengan parameter dari form
            $response = Http::get($apiBaseUrl, $queryParams);

            // Jika request berhasil, ambil data JSON
            if ($response->successful()) {
                $recommendedCars = $response->json();
            } else {
                // Jika API error, tampilkan pesan (opsional)
                session()->flash('api_error', 'Maaf, layanan rekomendasi sedang tidak tersedia.');
            }
        } catch (\Exception $e) {
            // Jika API tidak aktif sama sekali, tampilkan pesan
            session()->flash('api_error', 'Tidak dapat terhubung ke layanan rekomendasi.');
        }

        // Kirim data rekomendasi dan data untuk filter ke view 'landing.blade.php'
        return view('user.landing.index', compact('recommendedCars', 'allBrands', 'allModels'));
    }

    /**
     * Menampilkan detail dari satu mobil yang dipilih.
     */
    public function show(string $id)
    {
        // Logika untuk mengambil data satu mobil dari database
        return view('user.cars.show');
    }
}
