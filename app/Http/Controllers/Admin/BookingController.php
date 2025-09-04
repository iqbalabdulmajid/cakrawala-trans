<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
     /**
     * Menampilkan daftar semua pemesanan.
     */
    public function index()
    {
        // Ambil semua data booking, beserta data relasi user dan car
        // untuk menghindari query N+1. Urutkan dari yang terbaru.
        $bookings = Booking::with(['user', 'car'])->latest()->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Menampilkan detail dari satu pemesanan.
     */
    public function show(string $id)
    {
        // === PERBAIKAN DI SINI ===
        // Cari data booking secara manual berdasarkan ID.
        // Eager load relasi 'user' dan 'car' untuk efisiensi.
        // findOrFail akan otomatis menampilkan 404 jika ID tidak ditemukan.
        $booking = Booking::with(['user', 'car'])->findOrFail($id);

        // Kirim data booking yang sudah ditemukan ke view.
        return view('admin.bookings.show', compact('booking'));
    }

     /**
     * Memperbarui status dari sebuah pemesanan.
     */
     public function updateStatus(Request $request, Booking $booking)
    {
        // Validasi status dan catatan terlebih dahulu
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'return_notes' => 'nullable|string',
        ]);

        // --- LOGIKA PERBAIKAN ---
        // Validasi checklist HANYA JIKA status diubah menjadi 'completed'
        if ($request->input('status') === 'confirmed') {
            $request->validate([
                // 'accepted' adalah aturan terbaik untuk checkbox yang tidak wajib dicentang
                'cek_body' => 'sometimes|accepted',
                'cek_interior' => 'sometimes|accepted',
                'cek_ban' => 'sometimes|accepted',
                'cek_dokumen' => 'sometimes|accepted',
            ]);

            // Simpan data checklist jika validasi berhasil
            $booking->cek_body = $request->has('cek_body');
            $booking->cek_interior = $request->has('cek_interior');
            $booking->cek_ban = $request->has('cek_ban');
            $booking->cek_dokumen = $request->has('cek_dokumen');
        }

        // Simpan status dan catatan
        $booking->status = $validated['status'];
        $booking->return_notes = $validated['return_notes'];
        $booking->save();

        // Jika pesanan selesai atau dibatalkan, kembalikan status mobil
        if (in_array($booking->status, ['completed', 'cancelled'])) {
            if ($booking->car) {
                $booking->car->status = 'available';
                $booking->car->save();
            }
        }

        return redirect()->route('admin.bookings.show', $booking->id)
                         ->with('success', 'Status pesanan dan checklist berhasil diperbarui!');
    }
}
