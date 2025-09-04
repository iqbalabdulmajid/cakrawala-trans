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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel 'bookings'.
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->dateTime('payment_date');
            $table->string('payment_method');
            // Status pembayaran
            $table->string('status')->default('completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
