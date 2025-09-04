<?php

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
            // Mengubah tipe kolom menjadi DATETIME
            $table->dateTime('start_date')->change();
            $table->dateTime('end_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Mengembalikan tipe kolom menjadi DATE jika di-rollback
            $table->date('start_date')->change();
            $table->date('end_date')->change();
        });
    }
};
