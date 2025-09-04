<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
     public function index(Request $request)
    {
        // Tentukan tanggal default (bulan ini) jika tidak ada input
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Query dasar untuk booking yang sudah lunas
        $query = Booking::whereIn('status', ['confirmed', 'completed'])
                        ->whereBetween('created_at', [$startDate, $endDate]);

        // Kloning query agar tidak saling mempengaruhi
        $revenueQuery = clone $query;
        $transactionsQuery = clone $query;
        $chartQuery = clone $query;

        // Menghitung total pendapatan berdasarkan filter
        $totalRevenue = $revenueQuery->sum('total_price');

        // Menghitung jumlah total transaksi berdasarkan filter
        $totalTransactions = $transactionsQuery->count();

        // Mengambil 5 pesanan terbaru yang sudah lunas berdasarkan filter
        $latestTransactions = $query->with(['user', 'car'])->latest()->take(5)->get();

        // === PERBAIKAN QUERY GRAFIK DI SINI ===
        $monthlyRevenue = $chartQuery->select(
                                DB::raw("DATE_FORMAT(created_at, '%M %Y') as month"),
                                DB::raw("SUM(total_price) as revenue"),
                                // Ambil tanggal pertama dari setiap grup untuk pengurutan
                                DB::raw("MIN(created_at) as month_date")
                            )
                            ->groupBy('month')
                            // Urutkan berdasarkan tanggal yang kita ambil, bukan created_at mentah
                            ->orderBy('month_date', 'ASC')
                            ->get();

        $chartLabels = $monthlyRevenue->pluck('month');
        $chartData = $monthlyRevenue->pluck('revenue');

        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalTransactions',
            'latestTransactions',
            'chartLabels',
            'chartData',
            'startDate',
            'endDate'
        ));
    }
}
