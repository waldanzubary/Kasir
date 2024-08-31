<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\PaymentMail;
use App\Mail\Password;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Only admin can update status
        if (Auth::user()->role == 'Admin') {
            $request->validate([
                'status' => 'required|in:active,inactive',
            ]);

            $user->status = $request->status;
            $user->save();

            return redirect()->route('accounts.index')->with('success', 'Status updated successfully.');
        } else {
            return redirect()->route('accounts.index')->with('error', 'You are not authorized to change the status.');
        }
    }

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
            'password' => $request->password,  // Hash the password
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'shop_name' => $request->shop_name,
            'zip_code' => $request->zip_code,
            'status' => 'inactive',  // Default status
        ];

        // Create a new user
        $user = User::create($userData);

        // Automatically log the user in
        Auth::login($user);

        // Send a welcome email
        $email = new WelcomeMail();  // Assumes WelcomeMail is set up to be a Mailable class
        Mail::to($user->email)->send($email);  // Send email to the registered email address

        Session::flash('status', 'success');
        Session::flash('message', 'Please select the duration for your active date.');

        // Redirect to active date selection page
        return redirect('select-active-date');
    }

    public function selectActiveDate()
    {
        return view('Authorization/select-active-date');
    }

    public function selectActiveDateNoTrial()
    {
        return view('Authorization/select-active-date-no-trial');
    }

    public function selectActiveDateExtend()
    {
        return view('Authorization/select-active-date-extend');
    }

    public function setActiveDate(Request $request)
    {
        $user = Auth::user();

        if ($request->has('duration')) {
            $duration = $request->input('duration');
            $activationToken = Str::random(60); // Generate a random token

            switch ($duration) {
                case '5_days':
                    $user->active_date = now()->addDays(5);
                    break;
                case '1_month':
                    $user->active_date = now()->addMonth();
                    break;
                case '1_year':
                    $user->active_date = now()->addYear();
                    break;
                default:
                    return redirect()->back()->withErrors(['Invalid duration selected']);
            }

            $user->activation_token = $activationToken; // Store token
            $user->status = 'inactive';  // Ensure status is 'inactive' until activation
            $user->save();

            // Send activation email
            $email = new PaymentMail($user, $activationToken); // Pass the user and token to the email
            Mail::to($user->email)->send($email);

            // Log out the user
            Auth::logout();

            // Redirect to a static page
            return redirect('/activation-sent')->with('status', 'Your account setup is complete. Please check your email to activate your account.');
        }

        return redirect()->back()->withErrors(['Please select a duration']);
    }

            
    public function activateAccount($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect('login')->withErrors(['message' => 'Invalid activation token.']);
        }

        $user->activation_token = null; // Clear the token
        $user->status = 'active'; // Update status
        $user->save();

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

            // Masukkan pengguna ke dalam sesi
            Auth::login($user);
            $request->session()->regenerate();

            // Cek status pengguna
            if ($user->status == 'active') {
                // Jika status pengguna aktif, redirect berdasarkan role
                if (Auth::user()->role == 'Admin') {
                    return redirect('/dashboard');
                } elseif (Auth::user()->role == 'User') {
                    return redirect('/staff');
                }
            } else {
                // Jika akun tidak aktif, redirect ke halaman pilih durasi active date
                return redirect()->route('selectActiveDateNoTrial')
                    ->with('status', 'inactive')
                    ->with('message', 'Your account is not active. Please select the duration for your active date.');
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
            $user = Auth::user();
            
            // Check if the user's account is active
            if ($user->status == 'active') {
                $role = $user->role;

                // Redirect based on role
                if ($role == 'Admin') {
                    return redirect('/dashboard');
                } elseif ($role == 'User') {
                    return redirect('/staff');
                }
            } else {
                // If the account is not active, redirect to the select active date page
                return redirect()->route('selectActiveDateNoTrial')
                    ->with('status', 'inactive')
                    ->with('message', 'Your account is not active. Please select the duration for your active date.');
            }
        }

        return redirect('login');
    }


    public function editCombined()
    {
        $user = Auth::user();
        $user->active_date = $user->active_date ? Carbon::parse($user->active_date) : null;
        return view('profile.edit_combined', compact('user'));
    }

    // Update user profile and shop information
    public function updateCombined(Request $request)
    {
        $request->validate([
            // User Profile Fields
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',

            // Shop Information Fields
            'shop_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();

        // Update user profile fields
        $user->update($request->only('username', 'email'));

        // Update shop information fields
        $user->update($request->only('shop_name', 'address', 'city', 'zip_code', 'phone'));

        return redirect()->route('profile.edit_combined')->with('status', 'Profil dan informasi toko berhasil diperbarui.');
    }

    // Show password change form
    public function editPassword()
    {
        return view('profile.edit_password');
    }

    // Update password
    public function updatePassword(Request $request)
{
    // Validate the input
    $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    // Check if the current password matches the stored password
    if ($request->current_password !== $user->password) {
        return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
    }

    // Update the password without hashing
    $user->password = $request->new_password;
    $user->save();

    return redirect()->route('profile.edit_combined')->with('status', 'Password berhasil diperbarui.');
}


}
