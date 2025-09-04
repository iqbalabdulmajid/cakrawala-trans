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
        Schema::create('cars', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            // Menyimpan harga dengan format desimal
            $table->decimal('rental_price', 10, 2);
            $table->string('status')->default('available');
            $table->text('description')->nullable(); // Deskripsi bisa kosong
            $table->string('image')->nullable(); // Path gambar bisa kosong
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
