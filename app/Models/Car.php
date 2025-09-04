<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    /**
     * Atribut yang boleh diisi secara massal (mass assignable).
     * Ini adalah fitur keamanan Laravel untuk melindungi dari pengisian data yang tidak diinginkan.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brand',
        'model',
        'year',
        'rental_price',
        'status',
        'description',
        'image',
        'with_driver' // <-- TAMBAHKAN INI
    ];

    /**
     * The attributes that should be cast.
     * Ini memastikan tipe data tetap benar saat diubah menjadi array atau JSON,
     * yang penting saat mengirim data ke API Python.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'rental_price' => 'float',
        'with_driver' => 'boolean', // <-- TAMBAHKAN INI
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
