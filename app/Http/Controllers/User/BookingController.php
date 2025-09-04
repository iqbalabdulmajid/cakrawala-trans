<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Untuk bekerja dengan tanggal

class BookingController extends Controller
{

    public function index()
    {
        // Ambil semua pesanan milik user yang sedang login,
        // beserta data mobilnya (eager loading),
        // urutkan dari yang terbaru, dan paginasi.
        $bookings = Booking::where('user_id', Auth::id())
                            ->with('car')
                            ->latest()
                            ->paginate(10);

        return view('user.booking.index', compact('bookings'));
    }

    /**
     * Menampilkan halaman form pemesanan untuk mobil yang dipilih.
     */
    public function create(Car $car)
    {
        // Pastikan hanya user yang sudah login yang bisa mengakses
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk membuat pesanan.');
        }

        return view('user.booking.create', compact('car'));
    }

    /**
     * Menyimpan data pemesanan baru ke database.
     */
   public function store(Request $request, Car $car)
    {
        // 1. Validasi input dari form, termasuk KTP
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'nik' => 'required|string|max:16', // Validasi NIK
            'ktp_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi file KTP
            'name' => 'required|string|max:255', // Validasi nama
            'with_driver' => 'required|boolean', // Validasi pilihan dengan sopir atau tidak
            'sim_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi file SIM
        ]);
         $car = Car::findOrFail($request->car_id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // 2. Proses upload file KTP
        $ktpPath = null;
        if ($request->hasFile('ktp_image')) {
            // Simpan file ke public/storage/ktp_images dan dapatkan path-nya
            $ktpPath = $request->file('ktp_image')->store('ktp_images', 'public');
        }
            // Proses upload file SIM
        $simPath = null;
        if ($request->hasFile('sim_image')) {
            // Simpan file ke public/storage/sim_images dan dapatkan path-nya
            $simPath = $request->file('sim_image')->store('sim_images', 'public');
        }

        // 3. Hitung durasi dan total harga (menggunakan logika yang lebih sederhana dan benar)
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // diffInDays menghitung selisih hari penuh. Tambah 1 agar inklusif.
        // Contoh: 11 Juni -> 12 Juni = 1 hari selisih, jadi 1 + 1 = 2 hari sewa.
        $duration = $startDate->diffInDays($endDate) + 1;
        $totalPrice = $duration * $car->rental_price;

        // 4. Simpan data booking ke database
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
            'status' => 'confirmed', // Status awal adalah confirmed
            'nik' => $request->nik, // Simpan NIK
            'name' => $request->name,
            'ktp_image' => $ktpPath, // Simpan path file KTP
            'sim_image' => $simPath, // Simpan path file SIM
        ]);
        // Setelah booking dibuat, update status mobil menjadi 'not available'
        $car->status = 'not available';
        $car->save();

        // 5. Arahkan ke halaman selanjutnya (misalnya, riwayat atau pembayaran)
        // Anda bisa mengubah ini ke `route('payment.show', $booking->id)` jika sudah ada.
       return redirect()->route('payment.show', $booking->id);
    }
}
