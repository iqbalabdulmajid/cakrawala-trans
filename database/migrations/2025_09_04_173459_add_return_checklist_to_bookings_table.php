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
            // Menambahkan kolom setelah 'sim_image'
            // Menggunakan boolean untuk checkbox dan text untuk catatan
            $table->boolean('cek_body')->default(false)->after('sim_image');
            $table->boolean('cek_interior')->default(false)->after('cek_body');
            $table->boolean('cek_ban')->default(false)->after('cek_interior');
            $table->boolean('cek_dokumen')->default(false)->after('cek_ban');
            $table->text('return_notes')->nullable()->after('cek_dokumen');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['cek_body', 'cek_interior', 'cek_ban', 'cek_dokumen', 'return_notes']);
        });
    }
};
