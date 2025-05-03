<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function showRegistration(){
        return view('registration.show');
    }

    function submitRegistration(Request $request){

        $cekID = User::where('id', $request->id)->first();
        $cekEmail = User::where('email', $request->email)->first();
        
        if($cekID || $cekEmail){
            return redirect()->back()->with('gagal', 'Akun sudah terdaftar.');
        } else {
            $user = new User();
            $user->id = $request->id;
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->posisi = $request->posisi;
            $user->role = $request->role;
            $user->gaji = $request->gaji;
            $user->save();
            return redirect()->route('login.show')->with('sukses', 'Registrasi berhasil. Silakan login.');
        }
    }
    

    function showLogin(){
        return view('login.show');
    }

    function submitLogin(Request $request) {
        $data = $request->only('email','password');

        if (Auth::attempt($data)){
            $request->session()->regenerate();
            return redirect()->route('dashboard.home');
        }
        else {
            return redirect()->back()->with('gagal','Email atau password anda salah');
        }
    }

    function logout() {
        Auth::logout();
        return redirect()->route('login.show');
    }

    function showHome(){
        return view('dashboard.home');
    }
}
