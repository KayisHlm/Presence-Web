<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    function showLogin(){
        return view('login.show');
    }

function submitLogin(Request $request) {
    $email = $request->email;
    $password = $request->password;

    // Hardcoded admin
    if ($email === 'inticahaya@gmail.com' && $password === '123456') {
        $admin = User::where('email', $email)->first();

        if (!$admin) {
            // Buat akun admin jika belum ada
            $admin = User::create([
                'id' => 'admin001',
                'nama' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'Admin',
                'posisi' => 'Administrator',
                'gaji' => 0
            ]);
        }

        // Login menggunakan Auth Laravel
        Auth::login($admin);
        $request->session()->regenerate();
        return redirect()->route('dashboard.home');
    }

    // Login normal dari database
    if (Auth::attempt(['email' => $email, 'password' => $password])) {
        $request->session()->regenerate();
        return redirect()->route('dashboard.home');
    }

    return redirect()->back()->with('gagal', 'Email atau password anda salah');
}

    function logout() {
        Auth::logout();
        return redirect()->route('login.show');
    }

    function showHome(){
        return view('dashboard.home');
    }
}
