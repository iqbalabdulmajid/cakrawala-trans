<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; // <-- Pastikan ini di-import

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // Kita tidak akan menggunakan ini lagi karena redirect-nya dinamis
    // protected $redirectTo = '/home';


    /**
     * === TAMBAHKAN METHOD INI ===
     * * Menentukan ke mana pengguna akan diarahkan setelah login berhasil.
     *
     * @return string
     */
    public function redirectTo()
    {
        // Ambil peran (role) dari pengguna yang baru saja login
        $role = Auth::user()->role;

        // Periksa peran pengguna dan kembalikan rute yang sesuai
        switch ($role) {
            case 'admin':
                return route('admin.dashboard'); // Arahkan ke dashboard admin
                break;
            case 'user':
                return route('home'); // Arahkan ke halaman utama
                break;
            default:
                return route('home'); // Pengaman jika ada peran lain
                break;
        }
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
