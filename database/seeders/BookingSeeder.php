<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking; // <-- Import model Booking
use App\Models\Car;     // <-- Import model Car untuk mengambil harga
use Carbon\Carbon;      // <-- Import Carbon untuk manipulasi tanggal

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data mobil untuk mendapatkan harga sewanya
        $car3 = Car::find(3);
        $car4 = Car::find(4);
        $car5 = Car::find(5);

        // Pastikan data mobil ada sebelum membuat booking
        if (!$car3 || !$car4 || !$car5) {
            $this->command->info('Pastikan mobil dengan ID 3, 4, dan 5 sudah ada sebelum menjalankan BookingSeeder.');
            return;
        }

        // Contoh 1: Pesanan yang sudah selesai (completed) bulan lalu
        Booking::create([
            'user_id' => 4,
            'car_id' => 3,
            'start_date' => Carbon::now()->subMonth()->startOfMonth(),
            'end_date' => Carbon::now()->subMonth()->startOfMonth()->addDays(3),
            'total_price' => 4 * $car3->rental_price,
            'status' => 'completed',
            'created_at' => Carbon::now()->subMonth()->startOfMonth(),
            'updated_at' => Carbon::now()->subMonth()->startOfMonth(),
        ]);

        // Contoh 2: Pesanan yang sedang berjalan (confirmed)
        Booking::create([
            'user_id' => 5,
            'car_id' => 4,
            'start_date' => Carbon::now()->subDays(2),
            'end_date' => Carbon::now()->addDays(3),
            'total_price' => 6 * $car4->rental_price,
            'status' => 'confirmed',
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2),
        ]);

        // Update status mobil yang sedang disewa menjadi 'not available'
        $car4->status = 'not available';
        $car4->save();

        // Contoh 3: Pesanan yang menunggu pembayaran (pending) untuk minggu depan
        Booking::create([
            'user_id' => 6,
            'car_id' => 5,
            'start_date' => Carbon::now()->addWeek(),
            'end_date' => Carbon::now()->addWeek()->addDays(1),
            'total_price' => 2 * $car5->rental_price,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Contoh 4: Pesanan yang dibatalkan (cancelled)
        Booking::create([
            'user_id' => 1, // Admin juga bisa memesan
            'car_id' => 3,
            'start_date' => Carbon::now()->addDays(10),
            'end_date' => Carbon::now()->addDays(12),
            'total_price' => 3 * $car3->rental_price,
            'status' => 'cancelled',
            'created_at' => Carbon::now()->subDay(),
            'updated_at' => Carbon::now()->subDay(),
        ]);
    }
}
