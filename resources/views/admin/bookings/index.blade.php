@extends('layouts.admin')


{{-- 3. Mengisi 'slot' content. Semua yang ada di sini akan masuk ke @yield('content') --}}
@section('contents')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Semua Pemesanan</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Mobil</th>
                        <th>Tanggal Sewa</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            {{-- Gunakan optional() untuk mencegah error jika user terhapus --}}
                            <td>{{ optional($booking->user)->name }}</td>
                            {{-- Gunakan optional() untuk mencegah error jika mobil terhapus --}}
                            <td>{{ optional($booking->car)->brand }} {{ optional($booking->car)->model }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusClass = 'badge ';
                                    if ($booking->status == 'pending') {
                                        $statusClass .= 'bg-warning';
                                    } elseif ($booking->status == 'confirmed') {
                                        $statusClass .= 'bg-success';
                                    } elseif ($booking->status == 'cancelled') {
                                        $statusClass .= 'bg-danger';
                                    }
                                @endphp
                                <span class="{{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                    class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pemesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
