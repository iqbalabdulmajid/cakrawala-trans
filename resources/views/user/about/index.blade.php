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
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i
                                    class="ion-ios-arrow-forward"></i></a></span> <span>About us <i
                                class="ion-ios-arrow-forward"></i></span></p>
                    <h1 class="mb-3 bread">About Us</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section services-section">
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
                            <p>Tim kami siap membantu Anda 24 jam penuh. Hubungi kami kapan saja jika Anda membutuhkan
                                bantuan di perjalanan.</p>
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
                            <p>Ambil dan kembalikan mobil di berbagai lokasi strategis untuk kemudahan dan fleksibilitas
                                perjalanan Anda.</p>
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
                            <p>Pesan mobil impian Anda hanya dalam beberapa klik melalui sistem reservasi online kami yang
                                cepat dan aman.</p>
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
                            <p>Pilih dari berbagai jenis kendaraan, mulai dari mobil keluarga hingga sedan mewah, semua
                                dalam kondisi prima.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section services-section img" style="background-image: url(images/bg_2.jpg);">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
                    <span class="subheading">Work flow</span>
                    <h2 class="mb-3">How it works</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services services-2">
                        <div class="media-body py-md-4 text-center">
                            <div class="icon d-flex align-items-center justify-content-center"><span
                                    class="flaticon-route"></span></div>
                            <h3>Pick Destination</h3>
                            <p>A small river named Duden flows by their place and supplies it with you</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services services-2">
                        <div class="media-body py-md-4 text-center">
                            <div class="icon d-flex align-items-center justify-content-center"><span
                                    class="flaticon-select"></span></div>
                            <h3>Select Term</h3>
                            <p>A small river named Duden flows by their place and supplies it with you</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services services-2">
                        <div class="media-body py-md-4 text-center">
                            <div class="icon d-flex align-items-center justify-content-center"><span
                                    class="flaticon-rent"></span></div>
                            <h3>Choose A Car</h3>
                            <p>A small river named Duden flows by their place and supplies it with you</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services services-2">
                        <div class="media-body py-md-4 text-center">
                            <div class="icon d-flex align-items-center justify-content-center"><span
                                    class="flaticon-review"></span></div>
                            <h3>Enjoy The Ride</h3>
                            <p>A small river named Duden flows by their place and supplies it with you</p>
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
                                    <p class="mb-4">Pelayanannya sangat memuaskan, mobil bersih dan dalam kondisi prima.
                                        Proses sewa sangat cepat dan tidak berbelit-belit. Sangat direkomendasikan!</p>
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
                                    <p class="mb-4">Pilihan mobilnya banyak dan harganya kompetitif. Customer service
                                        sangat responsif membantu saya memilih mobil yang pas untuk keluarga. Terima kasih!
                                    </p>
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
                                    <p class="mb-4">Sangat terbantu dengan layanan antar-jemput di bandara. Membuat
                                        perjalanan bisnis saya di Bandung menjadi lebih efisien dan nyaman. Pasti akan sewa
                                        lagi.</p>
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
                                    <p class="mb-4">Pengalaman sewa mobil terbaik selama saya liburan. Mobil sesuai
                                        dengan yang ada di foto, bersih, dan wangi. Proses pengembalian juga sangat mudah.
                                    </p>
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

                        <p>Selamat datang di Cakrawala Trans Group. Kami adalah penyedia layanan rental mobil terpercaya
                            yang berkomitmen untuk memberikan pengalaman berkendara terbaik bagi setiap pelanggan. Kami
                            percaya bahwa perjalanan yang nyaman dimulai dengan kendaraan yang andal dan pelayanan yang
                            prima.</p>
                        <p>Misi kami adalah menyederhanakan proses penyewaan mobil melalui teknologi. Dengan armada yang
                            terawat baik dan sistem pemesanan online yang mudah, kami memastikan setiap perjalanan Anda,
                            baik untuk bisnis maupun liburan keluarga, berjalan lancar tanpa kendala. Kepercayaan dan
                            kepuasan Anda adalah prioritas utama kami.</p>
                        <p><a href="{{ route('car') }}" class="btn btn-primary">Lihat Pilihan Mobil</a></p>
                    </div>
                </div>
            </div>
        </div>
        @include('components.user.footer')
    @endsection
