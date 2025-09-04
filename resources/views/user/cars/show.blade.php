@extends('layouts.user')

{{-- Judul halaman akan dinamis sesuai nama mobil --}}
@section('title', 'Detail ' . $car->brand . ' ' . $car->model)
{{-- 1. Memberitahu Blade untuk menggunakan layout utama 'layouts/user.blade.php' --}}
@include('components.user.navbar')
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight"
        style="background-image: url('{{ $car?->image ? asset('storage/' . $car->image) : asset('user_template/images/bg_1.jpg') }}');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i
                                    class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a
                                href="{{ route('car') }}">Mobil <i class="ion-ios-arrow-forward"></i></a></span>
                        <span>Detail Mobil <i class="ion-ios-arrow-forward"></i></span></p>
                    {{-- Menggunakan null-safe operator (?->) untuk keamanan --}}
                    <h1 class="mb-3 bread">{{ $car?->brand }} {{ $car?->model }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-car-details">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="car-details">
                        <div class="text text-center">
                            <span class="subheading">Tahun: {{ $car?->year ?? 'N/A' }}</span>
                            <h2>{{ $car?->brand }} {{ $car?->model }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 pills">
                    <div class="bd-example bd-example-tabs">
                        <div class="d-flex justify-content-center">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-description-tab" data-toggle="pill"
                                        href="#pills-description" role="tab" aria-controls="pills-description"
                                        aria-expanded="true">Deskripsi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review"
                                        role="tab" aria-controls="pills-review" aria-expanded="true">Review</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-description" role="tabpanel"
                                aria-labelledby="pills-description-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="features">
                                            <li class="check"><span class="ion-ios-checkmark"></span>Status:
                                                {{ $car?->status ?? 'N/A' }}</li>
                                            <li class="check"><span class="ion-ios-checkmark"></span>Tahun:
                                                {{ $car?->year ?? 'N/A' }}</li>
                                            {{-- Tambahkan fitur lain jika ada di database Anda --}}
                                            <li class="check"><span class="ion-ios-checkmark"></span>Transmisi: Automatic
                                            </li>
                                            <li class="check"><span class="ion-ios-checkmark"></span>Kursi: 5 Dewasa</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="features">
                                            <li class="check"><span class="ion-ios-checkmark"></span>Bahan Bakar: Bensin
                                            </li>
                                            <li class="check"><span class="ion-ios-checkmark"></span>Pintu: 4</li>
                                            {{-- Tambahkan fitur lain jika ada di database Anda --}}
                                            <li class="check"><span class="ion-ios-checkmark"></span>AC: Ya</li>
                                            <li class="check"><span class="ion-ios-checkmark"></span>Audio: Ya</li>
                                            <li class="check"><span class="ion-ios-checkmark"></span>Sopir: {{ $car?->with_driver ? 'Ya' : 'Tidak' }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="price-wrap d-flex">
                                            <span class="rate">Rp
                                                {{ number_format($car?->rental_price ?? 0, 0, ',', '.') }}</span>
                                            <p class="from-day">
                                                <span>/hari</span>
                                            </p>
                                        </div>
                                        <p class="d-flex mb-0 d-block">
                                            <a href="{{route('booking.create',$car->id)}}" class="btn btn-primary py-2 mr-1">Sewa Sekarang</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h4>Deskripsi Lengkap</h4>
                                        <p>{{ $car?->description ?? 'Tidak ada deskripsi detail untuk mobil ini.' }}</p>
                                    </div>
                                </div>
                                {{-- fitur menampilkan jumlah mobil yang tersisa dengan merk yang sama --}}
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h4>Pilih Mobil Lain dengan merk {{ $car->brand }}</h4>
                                        @php
                                            $similarCars = \App\Models\Car::where('brand', $car->brand)
                                                ->where('id', '!=', $car->id)
                                                ->get();
                                        @endphp
                                        @if ($similarCars->isEmpty())
                                            <p>Tidak ada mobil lain dengan merek yang sama.</p>
                                        @else
                                            <ul>
                                                @foreach ($similarCars as $similarCar)
                                                    <li>{{ $similarCar->brand }} {{ $similarCar->model }} - Tahun:
                                                        {{ $similarCar->year }} - Status: {{ $similarCar->status }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>

                            </div>


                            <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h3 class="head">23 Reviews</h3>
                                        {{-- Nanti bagian review bisa dibuat dinamis --}}
                                    </div>
                                    <div class="col-md-5">
                                        <div class="rating-wrap">
                                            <h3 class="head">Beri Review</h3>
                                            {{-- Nanti form review bisa ditambahkan di sini --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
