@extends('layouts.admin')


{{-- 3. Mengisi 'slot' content. Semua yang ada di sini akan masuk ke @yield('content') --}}
@section('contents')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Mobil</h3>
            <div class="card-tools">
                <form action="{{ route('admin.mobil.sync') }}" method="POST" class="d-inline ml-2">
                    @csrf
                    <button type="submit" class="btn btn-info btn-sm"
                        title="Sinkronkan semua data mobil dari database ini ke API rekomendasi. Lakukan ini jika API baru dijalankan atau data tidak sinkron.">
                        <i class="fas fa-sync-alt"></i> Sync Data ke API
                    </button>
                </form>
                <a href="{{ route('admin.mobil.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Mobil Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.mobil.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari berdasarkan merek atau model..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </div>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>
                            <a
                                href="{{ route('admin.mobil.index', ['sort_by' => 'brand', 'sort_order' => $sortBy == 'brand' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                                Merek
                                @if ($sortBy == 'brand')
                                    <i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Gambar</th>
                        <th>
                            <a
                                href="{{ route('admin.mobil.index', ['sort_by' => 'model', 'sort_order' => $sortBy == 'model' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                                Model
                                @if ($sortBy == 'model')
                                    <i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('admin.mobil.index', ['sort_by' => 'rental_price', 'sort_order' => $sortBy == 'rental_price' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}">
                                Harga Sewa/Hari
                                @if ($sortBy == 'rental_price')
                                    <i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Status</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cars as $car)
                        <tr>
                            <td>{{ $cars->firstItem() + $loop->index }}</td>
                            <td>{{ $car->brand }}</td>
                            <td>
                                @if ($car->image)
                                    <img src="{{ asset('storage/' . $car->image) }}" alt="Gambar {{ $car->model }}"
                                        width="100">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                            <td>{{ $car->model }}</td>
                            <td>Rp {{ number_format($car->rental_price, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $car->status == 'available' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $car->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.mobil.edit', $car->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.mobil.destroy', $car->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data mobil ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{-- Link Paginasi --}}
            {{ $cars->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda tidak akan bisa mengembalikan data ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            event.target.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
