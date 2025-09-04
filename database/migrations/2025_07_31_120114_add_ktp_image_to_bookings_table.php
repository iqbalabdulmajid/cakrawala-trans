<?php
// File: database/migrations/xxxx_xx_xx_xxxxxx_add_ktp_image_to_bookings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Menambahkan kolom untuk menyimpan path gambar KTP setelah kolom total_price
            $table->string('ktp_image')->nullable()->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('ktp_image');
        });
    }
};
