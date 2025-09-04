@extends('layouts.user')
@include('components.user.navbar')

@section('title', 'Konfirmasi Pembayaran')

{{-- Tambahkan script Snap.js di header --}}
@push('head-scripts')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@endpush

@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('/images/bg_2.jpg') }}');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ route('home') }}">Home <i
                                    class="ion-ios-arrow-forward"></i></a></span>
                        <span>Pembayaran <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Konfirmasi & Pembayaran</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Ringkasan Pesanan Anda</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <h5 class="card-title">Mobil: {{ $booking->car->brand }} {{ $booking->car->model }}</h5>

                            <ul class="list-group list-group-flush">
                                {{-- INFORMASI NAMA DAN NIK DITAMBAHKAN DI SINI --}}
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Nama Pemesan:</span>
                                    <strong>{{ $booking->name }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>NIK:</span>
                                    <strong>{{ $booking->nik }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tanggal Mulai:</span>
                                    <strong>{{ \Carbon\Carbon::parse($booking->start_date)->format('d F Y') }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tanggal Selesai:</span>
                                    <strong>{{ \Carbon\Carbon::parse($booking->end_date)->format('d F Y') }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Durasi Sewa:</span>
                                    <strong>{{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) + 1 }}
                                        Hari</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total Tagihan:</span>
                                    <strong class="text-primary h4">Rp
                                        {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                                </li>
                            </ul>

                            {{-- FOTO KTP DITAMPILKAN DI SINI --}}
                            <div class="mt-4">
                                <h6>Dokumen Pendukung</h6>
                                <p><strong>Foto KTP:</strong></p>
                                @if ($booking->ktp_image)
                                    <a href="{{ asset('storage/' . $booking->ktp_image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $booking->ktp_image) }}" alt="Foto KTP" class="img-fluid rounded mb-3" style="max-height: 150px;">
                                    </a>
                                @else
                                    <p class="text-muted">Dokumen tidak ditemukan.</p>
                                @endif
                                <p><strong>Foto SIM:</strong></p>
                                @if ($booking->sim_image)
                                    <a href="{{ asset('storage/' . $booking->sim_image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $booking->sim_image) }}" alt="Foto SIM" class="img-fluid rounded mb-3" style="max-height: 150px;">
                                    </a>
                                @else
                                    <p class="text-muted">Dokumen tidak ditemukan.</p>
                                @endif
                            </div>


                            <div class="text-center mt-4">
                                <p>Silakan lakukan pembayaran untuk mengonfirmasi pesanan Anda.</p>
                                <button id="pay-button" class="btn btn-primary btn-lg">Bayar Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function() {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        // Ganti alert dengan notifikasi yang lebih baik jika perlu
                        alert("Pembayaran berhasil!");
                        console.log(result);
                        window.location.href = "/riwayat-pesanan";
                    },
                    onPending: function(result) {
                        alert("Menunggu pembayaran Anda!");
                        console.log(result);
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                        console.log(result);
                    },
                    onClose: function() {
                        alert('Anda menutup pop-up pembayaran sebelum selesai.');
                    }
                });
            });
        });
    </script>
@endpush
