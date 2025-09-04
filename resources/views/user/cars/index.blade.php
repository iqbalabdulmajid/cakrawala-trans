@extends('layouts.user')

{{-- 1. Memberitahu Blade untuk menggunakan layout utama 'layouts/user.blade.php' --}}
@include('components.user.navbar')
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_2.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i
                                    class="ion-ios-arrow-forward"></i></a></span> <span>Mobil <i
                                class="ion-ios-arrow-forward"></i></span></p>
                    <h1 class="mb-3 bread">Pilih Mobil Anda</h1>
                     <a href="{{ route('schedule.index') }}" class="btn btn-primary">Lihat Jadwal Ketersediaan</a>
                </div>

            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">
                {{-- Lakukan perulangan untuk setiap mobil di dalam collection $cars --}}
                @forelse ($cars as $car)
                    <div class="col-md-4">
                        <div class="car-wrap rounded ftco-animate">
                            {{-- Ganti dengan gambar mobil dinamis jika sudah ada --}}
                            <div class="img rounded d-flex align-items-end"
                                style="background-image: url('{{ $car->image ? asset('storage/' . $car->image) : asset('user_template/images/car-1.jpg') }}');">
                            </div>
                            <div class="text">
                                {{-- Tampilkan nama mobil dinamis --}}
                                <h2 class="mb-0"><a href="{{ route('cars.show', $car->id) }}">{{ $car->brand }}
                                        {{ $car->model }}</a></h2>
                                <div class="d-flex mb-3">
                                    <span class="cat">{{ $car->year }}</span>
                                    {{-- Tampilkan harga dinamis --}}
                                    <p class="price ml-auto">Rp {{ number_format($car->rental_price, 0, ',', '.') }}
                                        <span>/hari</span>
                                    </p>
                                </div>
                                {{-- Arahkan link ke halaman detail dinamis --}}
                                <p class="d-flex mb-0 d-block">
                                    @auth
                                        {{-- Jika user sudah login, arahkan ke halaman booking --}}
                                        <a href="{{ route('booking.create', $car->id) }}" class="btn btn-primary py-2 mr-1">Sewa
                                            Sekarang</a>
                                    @else
                                        {{-- Jika user belum login, arahkan ke halaman login --}}
                                        <a href="{{ route('login') }}" class="btn btn-primary py-2 mr-1">Sewa Sekarang</a>
                                    @endauth
                                    <a href="{{ route('cars.show', $car->id) }}"
                                        class="btn btn-secondary py-2 ml-1">Detail</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Tampilkan ini jika tidak ada mobil yang tersedia --}}
                    <div class="col-12 text-center">
                        <h3>Maaf, saat ini tidak ada mobil yang tersedia.</h3>
                        <p>Silakan kembali lagi nanti.</p>
                    </div>
                @endforelse
            </div>

            {{-- Bagian untuk menampilkan link Paginasi --}}
            <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                        {{ $cars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
