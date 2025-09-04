@extends('layouts.admin')


{{-- 3. Mengisi 'slot' content. Semua yang ada di sini akan masuk ke @yield('content') --}}
@section('contents')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Formulir Edit Mobil</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        {{-- Form akan dikirim ke route 'admin.mobil.update' dengan ID mobil --}}
        <form action="{{ route('admin.mobil.update', $mobil->id) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT') {{-- PENTING: Method untuk update adalah PUT --}}

            <div class="card-body">
                <div class="form-group">
                    <label for="brand">Merek Mobil</label>
                    {{-- 'old' akan mengambil input lama jika validasi gagal, jika tidak, ambil dari database --}}
                    <input type="text" class="form-control" id="brand" name="brand"
                        value="{{ old('brand', $mobil->brand) }}" required>
                </div>
                <div class="form-group">
                    <label for="model">Model Mobil</label>
                    <input type="text" class="form-control" id="model" name="model"
                        value="{{ old('model', $mobil->model) }}" required>
                </div>
                <div class="form-group">
                    <label for="year">Tahun</label>
                    <input type="number" class="form-control" id="year" name="year"
                        value="{{ old('year', $mobil->year) }}" required>
                </div>
                <div class="form-group">
                    <label for="rental_price">Harga Sewa / Hari</label>
                    <input type="number" class="form-control" id="rental_price" name="rental_price"
                        value="{{ old('rental_price', $mobil->rental_price) }}" required>
                </div>
                <div class="form-group">
                    <label for="with_driver">Dengan Sopir</label>
                    <select class="form-control" id="with_driver" name="with_driver" required>
                        <option value="1" {{ old('with_driver', $mobil->with_driver) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ !old('with_driver', $mobil->with_driver) ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="available" {{ old('status', $mobil->status) == 'available' ? 'selected' : '' }}>
                            Available</option>
                        <option value="not available"
                            {{ old('status', $mobil->status) == 'not available' ? 'selected' : '' }}>Not Available</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi (Opsional)</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $mobil->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="image">Gambar Mobil</label>
                    <p>Gambar saat ini:</p>
                    @if ($mobil->image)
                        <img src="{{ asset('storage/' . $mobil->image) }}" alt="Gambar {{ $mobil->model }}"
                            style="max-width: 200px; margin-bottom: 10px;">
                    @else
                        <p>Tidak ada gambar.</p>
                    @endif
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Pilih file baru untuk mengganti</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.mobil.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
