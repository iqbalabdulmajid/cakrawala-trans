<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car; // <-- PENTING: Mengimpor model Car
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function index()
    {

        $cars = Car::where('status', 'available')->latest()->paginate(12);


        return view('user.cars.index', compact('cars'));
    }


     public function show(string $id)
    {
         $car = Car::findOrFail($id);
        // Kirim data mobil yang ditemukan ke view 'user.cars.show'.
        return view('user.cars.show', compact('car'));
    }

}
