@extends('layouts.user')
@section('title', 'Riwayat Pesanan Saya')

{{-- 1. Memberitahu Blade untuk menggunakan layout utama 'layouts/user.blade.php' --}}
@include('components.user.navbar')
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_2.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span>
                        <span>Riwayat Pesanan <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Riwayat Pesanan Saya</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{-- Menampilkan pesan sukses setelah pembayaran --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @forelse ($bookings as $booking)
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>
                                    <strong>Pesanan #{{ $booking->id }}</strong> - Dibuat pada: {{ \Carbon\Carbon::parse($booking->created_at)->format('d F Y') }}
                                </span>
                                @php
                                    // Logika untuk menentukan warna badge berdasarkan status
                                    $statusClass = 'badge badge-secondary'; // Default
                                    if ($booking->status == 'pending') $statusClass = 'badge badge-warning';
                                    elseif ($booking->status == 'confirmed') $statusClass = 'badge badge-success';
                                    elseif ($booking->status == 'cancelled') $statusClass = 'badge badge-danger';
                                @endphp
                                <span class="{{ $statusClass }} p-2">{{ ucfirst($booking->status) }}</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        {{-- Memeriksa apakah relasi car ada sebelum menampilkannya --}}
                                        @if($booking->car)
                                            <h5 class="card-title">{{ $booking->car->brand }} {{ $booking->car->model }}</h5>
                                        @else
                                            <h5 class="card-title text-danger">Data Mobil Tidak Ditemukan</h5>
                                        @endif
                                        <p class="card-text mb-1">
                                            {{-- tambahkan jam --}}
                                            <strong>Dari:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d F Y H:i') }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Sampai:</strong> {{ \Carbon\Carbon::parse($booking->end_date)->format('d F Y H:i') }}
                                        </p>
                                        <h6 class="card-subtitle mb-2 text-muted">Total Harga: Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h6>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center justify-content-end">
                                        {{-- Jika status pending, tampilkan tombol bayar --}}
                                        @if($booking->status == 'pending')
                                            <a href="{{ route('payment.show', $booking->id) }}" class="btn btn-primary">Lanjutkan Pembayaran</a>
                                        @endif
                                        {{-- Tombol detail bisa dibuat nanti --}}
                                        {{-- <a href="#" class="btn btn-secondary ml-2">Lihat Detail</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-5 border rounded">
                            <h3>Anda belum memiliki riwayat pesanan.</h3>
                            <p>Mari mulai perjalanan Anda dengan menyewa mobil terbaik dari kami.</p>
                            <a href="{{ route('car') }}" class="btn btn-primary mt-3">Mulai Sewa Mobil</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Link Paginasi --}}
            <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                         {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
