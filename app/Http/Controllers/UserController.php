<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {

        $user = Auth::user();

        if ($user->role == 'Admin') {
            $users = User::all();
            return view('user.index',compact('users'));
        }
        else {
            return view('user.indexk', compact('user'));
        }
    }
    public function add() {
        return view('user.add');
    }
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'id' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'posisi' => 'required',
            'role' => 'required',
            'gaji' => 'required',
        ]);
        
        $validatedData['password'] = Hash::make($validatedData['password']);
        // Simpan data
        User::create($validatedData);
    
        // Redirect ke halaman index setelah berhasil
        return redirect()->route('user.index');
    }
    
    public function edit($id) {
        $user = User::find($id); // Ganti 'patient' dengan 'user'
        return view('user.edit', compact('user')); // Pastikan variabelnya sama
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'posisi' => 'required',
            'role' => 'required',
            'gaji' => 'required|numeric',
            // password tidak divalidasi required
        ]);
    
        // Kalau ada input password baru, hash dan simpan
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        } else {
            // Kalau password kosong, pakai password lama
            $validatedData['password'] = $user->password;
        }
    
        $user->update($validatedData);
    
        return redirect()->route('user.index')->with('success', 'User data successfully updated.');
    }
    
    
    public function destroy($id) {
        $user = User::find($id);
        
        if ($user) {
            $user->delete();
        }
    
        return redirect()->route('user.index');
    }
}    