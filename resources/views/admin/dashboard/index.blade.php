{{-- 1. Memberitahu Blade untuk menggunakan layout utama 'layouts/admin.blade.php' --}}
@extends('layouts.admin')


{{-- 3. Mengisi 'slot' content. Semua yang ada di sini akan masuk ke @yield('content') --}}
@section('contents')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                {{-- Widget Total Pemesanan --}}
                <div class="col-lg-4 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{ $jumlahBooking }}</h3>
                            <p>Total Pemesanan</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                            </path>
                        </svg>
                        <a href="{{ route('admin.bookings.index') }}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Lihat Detail <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>

                {{-- Widget Total Pelanggan --}}
                <div class="col-lg-4 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{ $jumlahUser }}</h3>
                            <p>Total Pelanggan</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                            </path>
                        </svg>
                        <a href="#" {{-- Ganti dengan route manajemen user jika ada --}}
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            Lihat Detail <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>

                {{-- Widget Total Mobil --}}
                <div class="col-lg-4 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ $jumlahMobil }}</h3>
                            <p>Total Mobil</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 016.375 7.5h1.5m17.25 4.5v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 0117.625 7.5h1.5m-7.5-6v.75c0 .621.504 1.125 1.125 1.125h1.5c.621 0 1.125-.504 1.125-1.125V1.5m-2.25 0h.008v.008h-.008V1.5z" />
                        </svg>
                        <a href="{{ route('admin.mobil.index') }}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Lihat Detail <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 connectedSortable">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Penyewaan</h3>
                        </div>
                        <div class="card-body">
                            {{-- Nanti chart akan dirender oleh JavaScript di sini --}}
                            <div id="revenue-chart"></div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-5 connectedSortable">
                    <div class="card mb-4">
                         <div class="card-header">
                            <h3 class="card-title">Statistik Lain</h3>
                        </div>
                        <div class="card-body">
                            <p>Area untuk statistik atau info lainnya.</p>
                        </div>
                    </div>
                </div>
                 </div> --}}
            </div>
        </div>
    @endsection

