<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('Authorization/login');
    }

    public function register()
    {
        return view('Authorization/register');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function registerProccess(Request $request)
    {
       // Validasi request
    $validated = $request->validate([
        'email' => 'required|unique:users|max:255|email',
        'username' => 'required|max:255',
        'password' => 'required|max:255', // Hilangkan aturan peng-hash-an

    ]);

    // Simpan data ke dalam array
    $userData = [
        'email' => $request->email,
        'username' => $request->username,
        'password' => $request->password, // Tetapkan password tanpa peng-hash-an

    ];

    // Buat user baru tanpa melakukan peng-hash-an pada password
    $user = User::create($userData);

    // Flash message dan redirect

    return redirect('login');
    }

    public function authenticating(Request $request)
    {
        // Mengambil username dan password dari permintaan
        $credentials = $request->only('username', 'password');

        // Mencari pengguna berdasarkan username
        $user = User::where('username', $credentials['username'])->first();

        // Jika pengguna ditemukan dan kata sandi cocok
        if ($user && $credentials['password'] == $user->password) {
            // Jika status pengguna aktif

                // Masukkan pengguna ke dalam sesi
                Auth::login($user);

                // Bersihkan pesan sesi
                Session::forget(['status', 'message']);


                $request->session()->regenerate();
                if(Auth::user()->role == 'Admin') {
                    return redirect('/dashboard');
                }

                if(Auth::user()->role == 'Warehouse Staff') {
                    return redirect('/Warehouse');
                }

                if(Auth::user()->role == 'Cashier') {
                    return redirect('/sales/create');
                }

                if(Auth::user()->role == 'User') {
                    return redirect('/transaction');
                }



        } else {
            // Jika autentikasi gagal
            Session::flash('status', 'failed');
            Session::flash('message', 'Invalid username or password');
        }

        // Redirect ke halaman login
        return redirect('login');
    }



}
