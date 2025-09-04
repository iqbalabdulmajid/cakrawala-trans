@extends('layouts.user')

@section('title', 'Jadwal Ketersediaan Mobil')
@include('components.user.navbar')
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span>
                        <span>Jadwal Ketersediaan <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Jadwal Ketersediaan Mobil</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>Halaman ini menampilkan status semua mobil kami secara real-time. Gunakan informasi ini untuk merencanakan penyewaan Anda.</p>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Mobil</th>
                                <th>Status</th>
                                <th>Kembali Tersedia Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cars as $car)
                                <tr>
                                    <td>
                                        <strong>{{ $car->brand }} {{ $car->model }}</strong> ({{ $car->year }})
                                    </td>
                                    <td>
                                        @if ($car->status == 'available')
                                            <span class="badge badge-success">Tersedia</span>
                                        @else
                                            <span class="badge badge-danger">Disewa</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($car->status != 'available' && $car->bookings->isNotEmpty())
                                            {{-- Ambil tanggal kembali dari booking aktif pertama --}}
                                            @php
                                                $returnDate = \Carbon\Carbon::parse($car->bookings->first()->end_date)->addDay();
                                            @endphp
                                            {{ $returnDate->format('d F Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data mobil untuk ditampilkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
