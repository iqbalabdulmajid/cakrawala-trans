<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // <-- PENTING: Mengimpor HTTP Client Laravel
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    // Variabel untuk menyimpan base URL API Flask Anda
    protected $apiBaseUrl = 'http://127.0.0.1:5001';

    /**
     * Menampilkan daftar semua mobil dengan fitur pencarian, urutan, dan paginasi.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('brand', 'like', '%' . $request->search . '%')
                ->orWhere('model', 'like', '%' . $request->search . '%');
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $cars = $query->paginate(10);

        return view('admin.cars.index', compact('cars', 'sortBy', 'sortOrder'));
    }

    /**
     * Menampilkan form untuk membuat mobil baru.
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Menyimpan mobil baru ke database dan mengirimkannya ke API Python.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990',
            'rental_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,not available',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'with_driver' => 'required|boolean', // <-- TAMBAHKAN INI
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            // Simpan gambar ke storage/app/public/cars dan ambil path-nya
            $path = $request->file('image')->store('cars', 'public');
            $validatedData['image'] = $path;
        }

        $car = Car::create($validatedData);

        // 2. Kirim data mobil baru tersebut ke API Flask
        try {
            // Menggunakan method toArray() agar data dikirim sebagai array,
            // termasuk data yang di-cast seperti year dan rental_price.
            Http::post($this->apiBaseUrl . '/api/car/add', $car->toArray());
        } catch (\Exception $e) {
            // Jika API tidak aktif atau error, tampilkan pesan peringatan
            return redirect()->route('admin.mobil.index')->with('warning', 'Mobil berhasil disimpan, tetapi gagal sinkronisasi ke API. Pastikan API KNN berjalan.');
        }

        // 3. Kembali ke halaman daftar mobil dengan pesan sukses
        return redirect()->route('admin.mobil.index')->with('success', 'Mobil baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit mobil.
     * Kita menggunakan Route Model Binding di sini untuk efisiensi.
     */
    public function edit(Car $mobil)
    {
        return view('admin.cars.edit', compact('mobil'));
    }

    /**
     * Memperbarui data mobil di database dan di API Python.
     */
    public function update(Request $request, Car $mobil)
    {
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990',
            'rental_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,not available',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'with_driver' => 'required|boolean', // <-- TAMBAHKAN INI
        ]);

        // Proses upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($mobil->image) {
                Storage::disk('public')->delete($mobil->image);
            }
            // Upload gambar baru dan update path
            $path = $request->file('image')->store('cars', 'public');
            $validatedData['image'] = $path;
        }

        $mobil->update($validatedData);

        // 2. Kirim data yang sudah diupdate ke API Flask
        try {
            Http::post($this->apiBaseUrl . '/api/car/update/' . $mobil->id, $validatedData);
        } catch (\Exception $e) {
            // Anda bisa menambahkan logging atau notifikasi jika gagal
        }

        return redirect()->route('admin.mobil.index')->with('success', 'Data mobil berhasil diperbarui!');
    }

    /**
     * Menghapus mobil dari database dan mengirim perintah hapus ke API Python.
     */
    public function destroy(Car $mobil)
    {
        // Hapus gambar dari storage saat mobil dihapus
        if ($mobil->image) {
            Storage::disk('public')->delete($mobil->image);
        }

        $carId = $mobil->id;
        $mobil->delete();

        // 2. Kirim perintah hapus ke API Flask
        try {
            Http::post($this->apiBaseUrl . '/api/car/delete/' . $carId);
        } catch (\Exception $e) {
            // Anda bisa menambahkan logging atau notifikasi jika gagal
        }

        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil dihapus!');
    }
    public function syncApi()
    {
        // Ambil semua data mobil dari database Laravel
        $allCars = \App\Models\Car::all();

        // Kirim ke endpoint sync di API Flask
        try {
            $response = Http::post('http://127.0.0.1:5001/api/cars/sync', $allCars->toArray());

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Sinkronisasi data mobil ke API berhasil!');
            } else {
                return redirect()->back()->with('error', 'Gagal sinkronisasi: API merespons dengan error.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal terhubung ke API Rekomendasi.');
        }
    }
}
