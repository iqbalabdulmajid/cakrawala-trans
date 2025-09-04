<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- Jangan lupa import model User
use Illuminate\Support\Facades\Hash; // <-- Jangan lupa import Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. MEMBUAT AKUN ADMIN
        User::create([
            'name' => 'Admin Cakrawala',
            'email' => 'admin@cakrawala.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang aman
            'role' => 'admin', // Menetapkan peran sebagai admin
        ]);

        // 2. MEMBUAT AKUN USER BIASA (PELANGGAN)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'user', // Peran default adalah user
        ]);

        User::create([
            'name' => 'Citra Lestari',
            'email' => 'citra@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Dewi Anggraini',
            'email' => 'dewi@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
