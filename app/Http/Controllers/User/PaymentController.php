<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans saat controller diinisialisasi
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Menampilkan halaman pembayaran dan membuat token Midtrans.
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'AKSES DITOLAK');
        }

        if (!$booking->car) {
            abort(404, 'Data mobil untuk pemesanan ini tidak ditemukan.');
        }

        // Siapkan parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                // PERBAIKAN: Gunakan order_id yang stabil tanpa timestamp
                'order_id' => 'BOOK-' . $booking->id,
                'gross_amount' => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            ],
        ];

        // Dapatkan Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($params);

        // Kirim data booking dan snapToken ke view
        return view('user.payment.show', compact('booking', 'snapToken'));
    }

    /**
     * Menangani notifikasi dari Midtrans (webhook).
     */
    public function handleNotification(Request $request)
    {
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;

        // Ekstrak ID booking dari order_id (misal: 'BOOK-123')
        $bookingId = str_replace('BOOK-', '', $orderId);
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return; // Booking tidak ditemukan, abaikan notifikasi.
        }

        // Logika utama untuk update status pesanan
        if ($transactionStatus == 'settlement') {
            // Hanya update jika status fraud 'accept'
            if ($fraudStatus == 'accept') {
                // Update status booking menjadi 'confirmed'
                $booking->status = 'confirmed';
                $booking->save();

                // === BAGIAN YANG KURANG: UPDATE STATUS MOBIL ===
                // Setelah pembayaran lunas, mobil menjadi tidak tersedia.
                if ($booking->car) {
                    $booking->car->status = 'not available';
                    $booking->car->save();
                }
            }
        } else if ($transactionStatus == 'expire' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
            // Jika pembayaran gagal atau dibatalkan
            $booking->status = 'cancelled';
            $booking->save();
        }

        return response()->json(['message' => 'Notification handled.']);
    }
}
