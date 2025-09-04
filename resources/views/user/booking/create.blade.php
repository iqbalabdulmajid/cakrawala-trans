@extends('layouts.user')

{{-- 1. Memberitahu Blade untuk menggunakan layout utama 'layouts/user.blade.php' --}}
@include('components.user.navbar')
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
                        <span class="mr-2"><a href="{{ route('cars.show', $car->id) }}">Detail Mobil <i
                                    class="ion-ios-arrow-forward"></i></a></span>
                        <span>Pemesanan <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Formulir Pemesanan</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h3 class="mb-4">Detail Mobil Pilihan Anda</h3>
                    <div class="car-details">
                        <div class="img rounded"
                            style="background-image: url('{{ $car->image ? asset('storage/' . $car->image) : asset('user_template/images/bg_1.jpg') }}'); background-size: cover; height: 300px;">
                        </div>
                        <div class="text text-center mt-4">
                            <span class="subheading">Tahun: {{ $car->year }}</span>
                            <h2>{{ $car->brand }} {{ $car->model }}</h2>
                            <h4>Rp {{ number_format($car->rental_price, 0, ',', '.') }} / hari</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">

                    <h3 class="mb-4">Pilih Tanggal Sewa</h3>
                    <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Simpan ID mobil secara tersembunyi --}}
                        <input type="hidden" name="car_id" value="{{ $car->id }}">

                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai Sewa</label>
                            <input type="datetime-local" name="start_date"
                                class="form-control @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai Sewa</label>
                            <input type="datetime-local" name="end_date"
                                class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}"
                                required>
                            @error('end_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- FIELD UPLOAD KTP --}}
                        <div class="form-group mt-4">
                            <label for="ktp_image"><strong>Upload Foto KTP</strong></label>
                            <p class="text-muted">Upload foto KTP Anda, dan kami akan coba isi NIK & Nama otomatis.</p>

                            {{-- PERBAIKAN: Menambahkan Progress Bar untuk Status OCR --}}
                            <div id="ocr-status" class="alert alert-info" style="display: none;">
                                <span id="ocr-status-text"></span>
                                <div class="progress mt-2" style="height: 10px; display: none;">
                                    <div id="ocr-progress-bar"
                                        class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                        style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <input type="file" class="form-control-file @error('ktp_image') is-invalid @enderror"
                                id="ktp_image" name="ktp_image" required accept="image/*">
                            @error('ktp_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-4">
                            <label for="sim_image"><strong>Upload Foto SIM</strong></label>
                            <p class="text-muted">Untuk keperluan verifikasi, harap unggah foto SIM Anda yang jelas.
                                (Format: JPG, PNG,
                                Maks: 2MB)</p>
                            <input type="file" class="form-control-file @error('sim_image') is-invalid @enderror"
                                id="sim_image" name="sim_image" required>
                            @error('sim_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-4">
                            <label for="name"><strong>Nama Lengkap (sesuai KTP)</strong></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Masukkan nama lengkap Anda" required
                                value="{{ old('name', auth()->user()->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <label for="nik"><strong>Nomor Induk Kependudukan (NIK)</strong></label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                name="nik" placeholder="Masukkan 16 digit NIK Anda" required
                                value="{{ old('nik') }}">
                            @error('nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group mt-4">
                            <label for="with_driver"><strong>Apakah Anda Memerlukan Sopir?</strong></label>
                            <select class="form-control @error('with_driver') is-invalid @enderror" id="with_driver"
                                name="with_driver" required>
                                <option value="1" {{ old('with_driver') == '1' ? 'selected' : '' }}>Ya, saya
                                    memerlukan sopir</option>
                                <option value="0" {{ old('with_driver') == '0' ? 'selected' : '' }}>Tidak, saya
                                    tidak memerlukan sopir</option>
                            </select>
                            @error('with_driver')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary py-3 px-4">Lanjutkan Pemesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{-- 1. Tambahkan library Tesseract.js --}}
    <script src='https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ktpImageInput = document.getElementById('ktp_image');
            const nikInput = document.getElementById('nik');
            const nameInput = document.getElementById('name');
            const ocrStatus = document.getElementById('ocr-status');
            const ocrStatusText = document.getElementById('ocr-status-text');
            const progressBarContainer = ocrStatus.querySelector('.progress');
            const progressBar = document.getElementById('ocr-progress-bar');

            ktpImageInput.addEventListener('change', async function(event) {
                const file = event.target.files[0];
                if (!file) {
                    return;
                }

                // Reset dan tampilkan UI
                ocrStatus.style.display = 'block';
                ocrStatus.className = 'alert alert-info';
                progressBarContainer.style.display = 'block';
                progressBar.style.width = '0%';
                ocrStatusText.textContent = 'Mempersiapkan OCR...';
                nameInput.readOnly = true;
                nikInput.readOnly = true;

                try {
                    // 2. Buat Tesseract worker dengan logger untuk progress
                    const worker = await Tesseract.createWorker('ind', 1, {
                        logger: m => {
                            if (m.status === 'recognizing text') {
                                const progress = Math.floor(m.progress * 100);
                                progressBar.style.width = progress + '%';
                                ocrStatusText.textContent =
                                    `Membaca gambar... (${progress}%)`;
                            } else {
                                // Menampilkan status lain seperti 'loading language traineddata'
                                ocrStatusText.textContent = 'Memuat model bahasa...';
                            }
                        }
                    });

                    // 3. Kenali teks dari gambar
                    const {
                        data: {
                            text
                        }
                    } = await worker.recognize(file);

                    progressBarContainer.style.display = 'none'; // Sembunyikan progress bar
                    ocrStatusText.textContent = 'Selesai membaca. Mencari NIK dan Nama...';

                    // =================================================================
                    // === PERBAIKAN LOGIKA EKSTRAKSI DATA DIMULAI DI SINI ===
                    // =================================================================
                    let nik = null;
                    let nama = null;

                    const lines = text.split('\n');

                    // --- Logika Pencarian NIK yang Lebih Baik ---
                    // Coba cari baris yang mengandung "NIK" lalu cari angka 16 digit setelahnya
                    let nikFound = false;
                    for (const line of lines) {
                        if (line.includes('NIK')) {
                            const nikMatch = line.match(/\b\d{16}\b/);
                            if (nikMatch) {
                                nik = nikMatch[0];
                                nikFound = true;
                                break;
                            }
                        }
                    }
                    // Jika tidak ketemu, cari saja angka 16 digit di mana pun
                    if (!nikFound) {
                        const nikMatch = text.match(/\b\d{16}\b/);
                        if (nikMatch) {
                            nik = nikMatch[0];
                        }
                    }

                    // --- Logika Pencarian Nama yang Lebih Baik ---
                    // Pola pada KTP adalah Nama hampir selalu berada di baris setelah baris "Nama"
                    let namaLineIndex = -1;
                    for (let i = 0; i < lines.length; i++) {
                        // Cari baris yang mengandung "Nama" tapi bukan "Alamat" atau "Agama"
                        if (lines[i].includes('Nama') && !lines[i].includes('Alamat') && !lines[i]
                            .includes('Agama')) {
                            // Coba ambil nama dari baris yang sama, setelah ':'
                            let nameOnSameLine = lines[i].split(':').pop().trim();
                            if (nameOnSameLine.length > 2 && isNaN(nameOnSameLine)) {
                                nama = nameOnSameLine;
                                break;
                            }
                            namaLineIndex = i;
                            break;
                        }
                    }

                    // Jika nama tidak ditemukan di baris yang sama, cari di baris berikutnya
                    if (!nama && namaLineIndex !== -1 && (namaLineIndex + 1) < lines.length) {
                        let potentialName = lines[namaLineIndex + 1].trim();
                        // Pastikan baris berikutnya bukan label lain (seperti "Tempat/Tgl Lahir")
                        if (potentialName.length > 2 && !potentialName.includes('Tempat')) {
                            nama = potentialName.split(':').pop().trim();
                        }
                    }

                    // Membersihkan karakter aneh dari nama
                    if (nama) {
                        nama = nama.replace(/[^a-zA-Z\s]/g, '');
                    }

                    // =================================================================
                    // === AKHIR DARI PERBAIKAN LOGIKA ===
                    // =================================================================

                    // 5. Isi form jika ditemukan
                    if (nik) nikInput.value = nik;
                    if (nama) nameInput.value = nama;

                    if (nik || nama) {
                        ocrStatusText.textContent = 'NIK dan Nama berhasil diisi otomatis!';
                        ocrStatus.className = 'alert alert-success';
                    } else {
                        ocrStatusText.textContent = 'Gagal menemukan NIK/Nama. Silakan isi manual.';
                        ocrStatus.className = 'alert alert-warning';
                    }

                    // 6. Matikan worker untuk membebaskan memori
                    await worker.terminate();

                } catch (error) {
                    console.error('OCR Error:', error);
                    ocrStatusText.textContent = 'Gagal memproses gambar. Silakan isi manual.';
                    ocrStatus.className = 'alert alert-danger';
                } finally {
                    nameInput.readOnly = false;
                    nikInput.readOnly = false;
                    progressBarContainer.style.display = 'none';
                }
            });
        });
    </script>
@endpush
