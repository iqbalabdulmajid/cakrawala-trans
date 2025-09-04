@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $booking->id)

@section('contents')
    <div class="container-fluid">
        {{-- Menampilkan pesan sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Menampilkan pesan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Harap periksa kembali input Anda. Jika menyelesaikan pesanan, pastikan semua checklist tercentang.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- CARD DETAIL PESANAN --}}
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Detail Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">ID Pesanan</th>
                                    <td>#{{ $booking->id }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            switch ($booking->status) {
                                                case 'pending': $statusClass = 'badge-warning'; break;
                                                case 'confirmed': $statusClass = 'badge-info'; break;
                                                case 'completed': $statusClass = 'badge-success'; break;
                                                case 'cancelled': $statusClass = 'badge-danger'; break;
                                            }
                                        @endphp
                                        <span style="color: black" class="badge {{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Sewa</th>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y, H:i') }} s/d {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Bayar</th>
                                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- CARD DATA PELANGGAN & DOKUMEN --}}
                    <div class="card card-primary card-outline mb-4">
                       <div class="card-header"><h5 class="card-title">Data Pelanggan & Dokumen</h5></div>
                       <div class="card-body">
                            <table class="table table-bordered">
                                <tr><th style="width: 200px;">Nama Lengkap</th><td>{{ $booking->name }}</td></tr>
                                <tr><th>NIK</th><td>{{ $booking->nik }}</td></tr>
                                <tr><th>KTP</th><td><a href="{{ asset('storage/' . $booking->ktp_image) }}" target="_blank" class="btn btn-sm btn-outline-info">Lihat KTP</a></td></tr>
                                <tr><th>SIM</th><td><a href="{{ asset('storage/' . $booking->sim_image) }}" target="_blank" class="btn btn-sm btn-outline-info">Lihat SIM</a></td></tr>
                            </table>
                       </div>
                    </div>

                    {{-- FORM CHECKLIST --}}
                    <div class="card card-info card-outline mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Checklist Kendaraan Saat Pengembalian</h5>
                        </div>
                        <div class="card-body">
                            <p>Form ini diisi saat mobil dikembalikan oleh pelanggan.</p>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cek_body" id="cek_body" value="1" {{ $booking->cek_body ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cek_body">Kondisi Body & Cat</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cek_interior" id="cek_interior" value="1" {{ $booking->cek_interior ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cek_interior">Kebersihan Interior</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cek_ban" id="cek_ban" value="1" {{ $booking->cek_ban ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cek_ban">Kondisi Ban & Velg</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cek_dokumen" id="cek_dokumen" value="1" {{ $booking->cek_dokumen ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cek_dokumen">Kelengkapan Dokumen</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="return_notes">Catatan Tambahan</label>
                                <textarea name="return_notes" id="return_notes" class="form-control" rows="3" placeholder="Contoh: Ada lecet di bumper, denda Rp 150.000">{{ old('return_notes', $booking->return_notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- AKSI FORM: UBAH STATUS & SUBMIT --}}
                    <div class="card card-secondary card-outline mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Aksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="status">Ubah Status Menjadi:</label>
                                <select name="status" class="form-control">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4">
                {{-- CARD DETAIL MOBIL --}}
                <div class="card card-primary card-outline mb-4">
                   <div class="card-header"><h5 class="card-title">Detail Mobil</h5></div>
                     <div class="card-body">
                        @if($booking->car)
                            <img src="{{ asset('storage/' . $booking->car->image) }}" class="img-fluid rounded mb-3" alt="Foto Mobil">
                            <h5>{{ $booking->car->brand }} {{ $booking->car->model }}</h5>
                            <p class="text-muted">{{ $booking->car->year }}</p>
                        @else
                            <p class="text-danger">Data mobil tidak ditemukan.</p>
                        @endif
                    </div>
                </div>

                {{-- HASIL CHECKLIST (SELALU DITAMPILKAN) --}}
                <div class="card card-success card-outline mb-4">
                    <div class="card-header"><h5 class="card-title">Hasil Checklist Pengembalian</h5></div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Kondisi Body & Cat: {!! $booking->cek_body ? '<i class="fas fa-check text-success"></i> <strong>Baik</strong>' : '<i class="fas fa-times text-danger"></i> <strong>Belum Dicek/Tidak Baik</strong>' !!}</li>
                            <li class="list-group-item">Kebersihan Interior: {!! $booking->cek_interior ? '<i class="fas fa-check text-success"></i> <strong>Baik</strong>' : '<i class="fas fa-times text-danger"></i> <strong>Belum Dicek/Tidak Baik</strong>' !!}</li>
                            <li class="list-group-item">Kondisi Ban & Velg: {!! $booking->cek_ban ? '<i class="fas fa-check text-success"></i> <strong>Baik</strong>' : '<i class="fas fa-times text-danger"></i> <strong>Belum Dicek/Tidak Baik</strong>' !!}</li>
                            <li class="list-group-item">Kelengkapan Dokumen: {!! $booking->cek_dokumen ? '<i class="fas fa-check text-success"></i> <strong>Baik</strong>' : '<i class="fas fa-times text-danger"></i> <strong>Belum Dicek/Tidak Baik</strong>' !!}</li>
                        </ul>
                        @if($booking->return_notes)
                            <div class="mt-3">
                                <strong>Catatan Tambahan dari Admin:</strong>
                                <p class="mt-2 blockquote-footer"><em>{{ $booking->return_notes }}</em></p>
                            </div>
                        @else
                             <p class="text-muted mt-3">Tidak ada catatan tambahan.</p>
                        @endif
                    </div>
                 </div>
            </div>
        </div>
    </div>
@endsection

