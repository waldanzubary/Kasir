<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{

    public function sendEmail()
    {
        $email = new WelcomeMail();
        Mail::to('anggerrestu10@gmail.com')->send($email);

        return 'Email sent!';
    }

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
        // Validate request
        $validated = $request->validate([
            'email' => 'required|unique:users|max:255|email',
            'username' => 'required|max:255',
            'password' => 'required|max:255',
            'city' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'shop_name' => 'required',
            'zip_code' => 'required',
        ]);

        // Save data into an array, hash the password
        $userData = [
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),  // Hash the password
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'shop_name' => $request->shop_name,
            'zip_code' => $request->zip_code,
        ];

        // Create a new user
        $user = User::create($userData);

        // Send a welcome email
        $email = new WelcomeMail();  // Assumes WelcomeMail is set up to be a Mailable class
        Mail::to($user->email)->send($email);  // Send email to the registered email address

        Session::flash('status', 'success');
        Session::flash('message', 'Please check your email for further instructions.');

        // Flash message and redirect
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
            if ($user->status == 'active') {
            // Jika status pengguna aktif

                // Masukkan pengguna ke dalam sesi
                Auth::login($user);

                // Bersihkan pesan sesi
                Session::forget(['status', 'message']);


                $request->session()->regenerate();
                if(Auth::user()->role == 'Admin') {
                    return redirect('/dashboard');
                }

                if(Auth::user()->role == 'User') {
                    return redirect('/transaction');
                }

            } else {
                // Jika akun tidak aktif
                Session::flash('status', 'failed');
                Session::flash('message', 'Your account is not active');
            }



        } else {
            // Jika autentikasi gagal
            Session::flash('status', 'failed');
            Session::flash('message', 'Invalid username or password');
        }

        // Redirect ke halaman login
        return redirect('login');
    }

    public function redirectBasedOnRole()
    {
        if (Auth::check()) {

            $role = Auth::user()->role;

            if ($role == 'Admin') {
                return redirect('/dashboard');
            } elseif ($role == 'User') {
                return redirect('/transaction');
            }
        }

        return redirect('login');
    }

}
