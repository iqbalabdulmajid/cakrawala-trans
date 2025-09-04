{{-- 1. Memberitahu Blade untuk menggunakan layout utama 'layouts/admin.blade.php' --}}
@extends('layouts.admin')


{{-- 3. Mengisi 'slot' content. Semua yang ada di sini akan masuk ke @yield('content') --}}
@section('contents')
     {{-- FORM FILTER TANGGAL --}}
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">Filter Laporan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.reports.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="start_date" class="form-label">Dari Tanggal:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-5">
                        <label for="end_date" class="form-label">Sampai Tanggal:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-2">
                       <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- WIDGET STATISTIK --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p>Total Pendapatan (Berdasarkan Filter)</p>
                </div>
                <div class="icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>{{ $totalTransactions }}</h3>
                    <p>Total Transaksi (Berdasarkan Filter)</p>
                </div>
                <div class="icon">
                    <i class="bi bi-bar-chart-line-fill"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- KARTU UNTUK GRAFIK PENDAPATAN --}}
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Grafik Pendapatan per Bulan</h3>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="revenueChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>

    {{-- TABEL TRANSAKSI TERAKHIR --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">5 Transaksi Lunas Terbaru</h3>
        </div>
        <div class="card-body p-0"> {{-- p-0 untuk membuat tabel lebih rapat --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th>Pelanggan</th>
                        <th>Mobil</th>
                        <th>Total Bayar</th>
                        <th>Tanggal Pesan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestTransactions as $transaction)
                        <tr>
                            <td>#{{ $transaction->id }}</td>
                            <td>{{ optional($transaction->user)->name }}</td>
                            <td>{{ optional($transaction->car)->brand }} {{ optional($transaction->car)->model }}</td>
                            <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4">Belum ada transaksi yang lunas pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Memuat library Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart');
        if (ctx) {
            const chartLabels = {!! json_encode($chartLabels) !!};
            const chartData = {!! json_encode($chartData) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: chartData,
                        backgroundColor: 'rgba(23, 162, 184, 0.7)', // Warna .bg-info
                        borderColor: 'rgba(23, 162, 184, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
