<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * Atribut yang boleh diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'ktp_image',
        'sim_image',
        'nik',
        'name',
        'with_driver',
        'cek_body',
        'cek_interior',
        'cek_ban',
        'cek_dokumen',
        'return_notes',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'total_price' => 'float',
    ];
    /**
     * Mendefinisikan relasi "belongsTo" ke model Car.
     * Ini adalah bagian yang hilang. Fungsi ini memberitahu Laravel
     * bagaimana cara menemukan data Mobil dari sebuah Pesanan.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Ini memberitahu Laravel bagaimana cara menemukan data Pengguna dari sebuah Pesanan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
