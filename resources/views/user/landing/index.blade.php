@extends('layouts.user')

{{-- 1. Memberitahu Blade untuk menggunakan layout utama 'layouts/user.blade.php' --}}
@include('components.user.navbar')
@section('content')
   <div class="hero-wrap" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text justify-content-start align-items-center">
                <div class="col-lg-8 ftco-animate">
                    <div class="text w-100 text-center mb-md-5 pb-md-5">
                        <h1 class="mb-4">Cepat & Mudah Menyewa Mobil</h1>
                        <p style="font-size: 18px;">Pilihan terbaik untuk perjalanan Anda, jelajahi berbagai destinasi dengan nyaman bersama kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<br>

    {{-- Bagian Menampilkan Hasil Rekomendasi --}}
    <section class="ftco-section">
        <div class="container-fluid px-4">
            <div class="row justify-content-center">
                <div class="col-md-12 heading-section text-center ftco-animate mb-5">
                    <span class="subheading">Pilihan Terbaik Untuk Anda</span>
                    <h2 class="mb-2">Mobil Rekomendasi</h2>
                </div>
            </div>
            {{-- Filter Section dengan KNN --}}
            <section class="ftco-section ftco-no-pb ftco-no-pt">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search-wrap-1 ftco-animate mb-5">
                                {{-- Form ini akan mengirim data ke LandingController --}}
                                <form action="{{ route('home') }}" method="GET" class="search-property-1">
                                    <div class="row">
                                        {{-- Filter Merek Mobil (Dinamis) --}}
                                        <div class="col-lg align-items-end">
                                            <div class="form-group">
                                                <label for="brand">Pilih Merek</label>
                                                <div class="form-field">
                                                    <div class="select-wrap">
                                                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                                        <select name="brand" id="brand" class="form-control">
                                                            <option value="">Semua Merek</option>
                                                            @foreach ($allBrands as $brand)
                                                                <option value="{{ $brand }}"
                                                                    {{ request('brand') == $brand ? 'selected' : '' }}>
                                                                    {{ $brand }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Filter Model Mobil (Dinamis) --}}
                                        <div class="col-lg align-items-end">
                                            <div class="form-group">
                                                <label for="model">Pilih Model</label>
                                                <div class="form-field">
                                                    <div class="select-wrap">
                                                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                                        <select name="model" id="model" class="form-control">
                                                            <option value="">Semua Model</option>
                                                            @foreach ($allModels as $model)
                                                                <option value="{{ $model }}"
                                                                    {{ request('model') == $model ? 'selected' : '' }}>
                                                                    {{ $model }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Filter Harga (Contoh) --}}
                                        <div class="col-lg align-items-end">
                                            <div class="form-group">
                                                <label for="rental_price">Batas Harga</label>
                                                <div class="form-field">
                                                    <input type="number" name="rental_price" class="form-control"
                                                        placeholder="Contoh: 500000"
                                                        value="{{ request('rental_price') }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Tombol Search --}}
                                        <div class="col-lg align-self-end">
                                            <div class="form-group">
                                                <div class="form-field">
                                                    <input type="submit" value="Cari Rekomendasi"
                                                        class="form-control btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Menampilkan pesan jika API error --}}
            @if (session('api_error'))
                <div class="alert alert-danger text-center">{{ session('api_error') }}</div>
            @endif

            <div class="row">
                {{-- Looping hasil dari API KNN --}}
                 @forelse ($recommendedCars as $car)
                    <div class="col-md-4">
                        <div class="car-wrap rounded ftco-animate">
                            {{-- Memeriksa apakah kunci 'image' ada dan tidak null --}}
                            <div class="img rounded d-flex align-items-end" style="background-image: url('{{ (isset($car['image']) && $car['image']) ? asset('storage/' . $car['image']) : asset('user_template/images/car-default.jpg') }}');">
                            </div>
                            <div class="text">
                                <h2 class="mb-0"><a href="{{ route('cars.show', $car['id']) }}">{{ $car['brand'] }} {{ $car['model'] }}</a></h2>
                                <div class="d-flex mb-3">
                                    <span class="cat">{{ $car['year'] }}</span>
                                    <p class="price ml-auto">Rp {{ number_format($car['rental_price'], 0, ',', '.') }} <span>/hari</span></p>
                                </div>
                                <p class="d-flex mb-0 d-block">
                                   @auth
                                        {{-- Jika user sudah login, arahkan ke halaman booking --}}
                                        <a href="{{ route('booking.create', $car['id']) }}" class="btn btn-primary py-2 mr-1">Sewa Sekarang</a>
                                    @else
                                        {{-- Jika user belum login, arahkan ke halaman login --}}
                                        <a href="{{ route('login') }}" class="btn btn-primary py-2 mr-1">Sewa Sekarang</a>
                                    @endauth
                                    <a href="{{ route('cars.show', $car['id']) }}" class="btn btn-secondary py-2 ml-1">Detail</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Maaf, tidak ditemukan rekomendasi yang cocok. Silakan coba filter yang berbeda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="ftco-section services-section ftco-no-pt ftco-no-pb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 heading-section text-center ftco-animate mb-5">
                <span class="subheading">Layanan Kami</span>
                <h2 class="mb-2">Komitmen Kami Untuk Anda</h2>
            </div>
        </div>
        <div class="row d-flex">
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services">
                    <div class="media-body py-md-4">
                        <div class="d-flex mb-3 align-items-center">
                            <div class="icon"><span class="flaticon-customer-support"></span></div>
                            <h3 class="heading mb-0 pl-3">Dukungan 24/7</h3>
                        </div>
                        <p>Tim kami siap membantu Anda 24 jam penuh. Hubungi kami kapan saja jika Anda membutuhkan bantuan di perjalanan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services">
                    <div class="media-body py-md-4">
                        <div class="d-flex mb-3 align-items-center">
                            <div class="icon"><span class="flaticon-route"></span></div>
                            <h3 class="heading mb-0 pl-3">Banyak Lokasi</h3>
                        </div>
                        <p>Ambil dan kembalikan mobil di berbagai lokasi strategis untuk kemudahan dan fleksibilitas perjalanan Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services">
                    <div class="media-body py-md-4">
                        <div class="d-flex mb-3 align-items-center">
                            <div class="icon"><span class="flaticon-online-booking"></span></div>
                            <h3 class="heading mb-0 pl-3">Reservasi Mudah</h3>
                        </div>
                        <p>Pesan mobil impian Anda hanya dalam beberapa klik melalui sistem reservasi online kami yang cepat dan aman.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services">
                    <div class="media-body py-md-4">
                        <div class="d-flex mb-3 align-items-center">
                            <div class="icon"><span class="flaticon-rent"></span></div>
                            <h3 class="heading mb-0 pl-3">Mobil Terbaik</h3>
                        </div>
                        <p>Pilih dari berbagai jenis kendaraan, mulai dari mobil keluarga hingga sedan mewah, semua dalam kondisi prima.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <section class="ftco-section testimony-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center heading-section ftco-animate">
                <span class="subheading">Testimoni</span>
                <h2 class="mb-3">Pelanggan Kami yang Bahagia</h2>
            </div>
        </div>
        <div class="row ftco-animate">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel ftco-owl">
                    <div class="item">
                        <div class="testimony-wrap text-center py-4 pb-5">
                            <div class="user-img mb-4" style="background-image: url(images/person_1.jpg)">
                            </div>
                            <div class="text pt-4">
                                <p class="mb-4">Pelayanannya sangat memuaskan, mobil bersih dan dalam kondisi prima. Proses sewa sangat cepat dan tidak berbelit-belit. Sangat direkomendasikan!</p>
                                <p class="name">Budi Santoso</p>
                                <span class="position">Traveler</span>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimony-wrap text-center py-4 pb-5">
                            <div class="user-img mb-4" style="background-image: url(images/person_2.jpg)">
                            </div>
                            <div class="text pt-4">
                                <p class="mb-4">Pilihan mobilnya banyak dan harganya kompetitif. Customer service sangat responsif membantu saya memilih mobil yang pas untuk keluarga. Terima kasih!</p>
                                <p class="name">Citra Lestari</p>
                                <span class="position">Ibu Rumah Tangga</span>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimony-wrap text-center py-4 pb-5">
                            <div class="user-img mb-4" style="background-image: url(images/person_3.jpg)">
                            </div>
                            <div class="text pt-4">
                                <p class="mb-4">Sangat terbantu dengan layanan antar-jemput di bandara. Membuat perjalanan bisnis saya di Bandung menjadi lebih efisien dan nyaman. Pasti akan sewa lagi.</p>
                                <p class="name">Ahmad Dhani</p>
                                <span class="position">Pengusaha</span>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimony-wrap text-center py-4 pb-5">
                            <div class="user-img mb-4" style="background-image: url(images/person_1.jpg)">
                            </div>
                            <div class="text pt-4">
                                <p class="mb-4">Pengalaman sewa mobil terbaik selama saya liburan. Mobil sesuai dengan yang ada di foto, bersih, dan wangi. Proses pengembalian juga sangat mudah.</p>
                                <p class="name">Doni Setiawan</p>
                                <span class="position">Mahasiswa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center"
                style="background-image: url(images/about.jpg);">
            </div>
            <div class="col-md-6 wrap-about py-md-5 ftco-animate">
                <div class="heading-section mb-5 pl-md-5">
                    <span class="subheading">Tentang Kami</span>
                    <h2 class="mb-4">Pilihan Tepat untuk Perjalanan Sempurna Anda</h2>

                    <p>Selamat datang di Cakrawala Trans Group. Kami adalah penyedia layanan rental mobil terpercaya yang berkomitmen untuk memberikan pengalaman berkendara terbaik bagi setiap pelanggan. Kami percaya bahwa perjalanan yang nyaman dimulai dengan kendaraan yang andal dan pelayanan yang prima.</p>
                    <p>Misi kami adalah menyederhanakan proses penyewaan mobil melalui teknologi. Dengan armada yang terawat baik dan sistem pemesanan online yang mudah, kami memastikan setiap perjalanan Anda, baik untuk bisnis maupun liburan keluarga, berjalan lancar tanpa kendala. Kepercayaan dan kepuasan Anda adalah prioritas utama kami.</p>
                    <p><a href="{{ route('car') }}" class="btn btn-primary">Lihat Pilihan Mobil</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

    @include('components.user.footer')
@endsection
