<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman register 
    public function showRegister()
    {
        return view('register');
    }

    // Proses data register
    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:100',
                'email_or_phone' => [
                    'required',
                    'regex:/^(^[0-9]{10,13}$)|(^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$)$/'
                ],
                'password' => 'required|min:6|confirmed',
            ],
            [
                // custom error messages
                'email_or_phone.required' => 'Email or phone number must be filled in.',
                'email_or_phone.regex' => 'Enter a valid email or phone number.',
                'password.confirmed' => 'Confirm password does not match.',
                'password.min' => 'Password must be at least 6 characters.'
            ],
            [
                // alias agar tidak tampil "email_or_phone"
                'email_or_phone' => 'Email/Nomor HP'
            ]
        );

        $input = $request->input('email_or_phone');

        if (ctype_digit($input)) { // hanya digit -> phone
            $phone = $input;
            $email = null;

            // cek unik phone
            $exists = \App\Models\User::where('phone', $phone)->exists();
            if ($exists) {
                return back()->withErrors(['email_or_phone' => 'Phone number already registered.'])->withInput();
            }
        } else { // anggap email
            $email = $input;
            $phone = null;

            // cek unik email
            $exists = \App\Models\User::where('email', $email)->exists();
            if ($exists) {
                return back()->withErrors(['email_or_phone' => 'Email already registered.'])->withInput();
            }
        }

        User::create([
            'name'     => $request->name,
            'email'    => $email,
            'phone'    => $phone,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Account created successfully!');
    }

    // Tampilkan halaman login
    public function showLogin()
    {
        return view('login');
    }

    // Proses login 
    public function login(Request $request)
    {
        $request->validate(
            [
                'login'    => 'required',
                'password' => 'required'
            ],
            [
                // alias agar tidak muncul "login"
                'login' => 'Username/Email/Nomor HP'
            ]
        );

        // Tentukan kolom mana yang dipakai untuk login
        if (ctype_digit($request->login)) {
            $credentialKey = 'phone';          // kalau angka -> phone
        } elseif (strpos($request->login, '@') !== false) {
            $credentialKey = 'email';          // kalau ada @ -> email
        } else {
            $credentialKey = 'name';           // selain itu -> username
        }

        if (Auth::attempt([$credentialKey => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();
            return back()->with('success', 'Login Successful!');
        }

        return back()->withErrors(['login' => 'Incorrect username/email/phone number or password.']);
    }

    // Logout 
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have logged out.');
    }
}
