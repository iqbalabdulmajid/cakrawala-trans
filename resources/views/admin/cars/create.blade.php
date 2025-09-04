@extends('layouts.admin')


{{-- 3. Mengisi 'slot' content. Semua yang ada di sini akan masuk ke @yield('content') --}}
@section('contents')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Formulir Tambah Mobil</h3>
        </div>
        <form action="{{ route('admin.mobil.store') }}" enctype="multipart/form-data" method="POST">
            @csrf {{-- Wajib ada untuk keamanan form Laravel --}}
            <div class="card-body">
                <div class="form-group">
                    <label for="brand">Merek Mobil</label>
                    <input type="text" class="form-control" id="brand" name="brand" placeholder="Contoh: Toyota"
                        required>
                </div>
                <div class="form-group">
                    <label for="model">Model Mobil</label>
                    <input type="text" class="form-control" id="model" name="model" placeholder="Contoh: Avanza"
                        required>
                </div>
                <div class="form-group">
                    <label for="year">Tahun</label>
                    <input type="number" class="form-control" id="year" name="year" placeholder="Contoh: 2020"
                        required>
                </div>
                <div class="form-group">
                    <label for="rental_price">Harga Sewa / Hari</label>
                    <input type="number" class="form-control" id="rental_price" name="rental_price"
                        placeholder="Contoh: 300000" required>
                </div>
                <div class="form-group">
                    <label for="with_driver">Dengan Sopir</label>
                    <select class="form-control" id="with_driver" name="with_driver" required>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="available">Available</option>
                        <option value="not available">Not Available</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi (Opsional)</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Gambar Mobil</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Pilih file</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.mobil.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
