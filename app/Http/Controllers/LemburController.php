<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use App\Models\Lembur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LemburController extends Controller
{
    public function index()
    {
        // Mengecek peran pengguna (Admin atau Karyawan)
        if (Auth::check()) {
            if (Auth::user()->role === 'Admin') {
                // Admin bisa melihat semua data lembur
                $lemburs = Lembur::with('user')->get();
            } else {
                // Karyawan hanya bisa melihat lemburnya sendiri
                $lemburs = Lembur::with('user')
                    ->where('user_id', Auth::user()->id)
                    ->get();
            }

            return view('lembur.index', compact('lemburs'));
        } else {
            return redirect()->route('login')->with('error', 'You must login first.');
        }
    }

    // Approve Lembur
    public function approve($user_id, $tanggal)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('lembur.index')->with('error', 'You do not have the right to perform this action.');
        }
    
        Lembur::where('user_id', $user_id)
              ->where('tanggal', $tanggal)
              ->update(['status' => 'approved']);
    
        return redirect()->route('lembur.index')->with('success', 'Overtime successfully approved');
    }

    // Reject Lembur
    public function reject($user_id, $tanggal)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('lembur.index')->with('error', 'You do not have the right to perform this action.');
        }
    
        Lembur::where('user_id', $user_id)
              ->where('tanggal', $tanggal)
              ->update(['status' => 'rejected']);
    
        return redirect()->route('lembur.index')->with('success', 'Overtime was successfully rejected');
    }

    // Hapus Lembur
    public function destroy($user_id, $tanggal)
    {
        // Pastikan Admin yang melakukan aksi delete
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('lembur.index')->with('error', 'You do not have the right to perform this action.');
        }

        $lembur = Lembur::where('user_id', $user_id)
                        ->where('tanggal', $tanggal)
                        ->firstOrFail();

        $lembur->delete();

        return redirect()->route('lembur.index')->with('success', 'Overtime successfully deleted');
    }

    public function create()
    {
        $users = Auth::user()->role === 'Admin' ? User::all() : collect(); // lebih aman
        return view('lembur.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jam_lembur' => 'required|integer',
            'tanggal' => 'required|date',
        ]);

        Lembur::create([
            'user_id' => Auth::user()->id,
            'jam_lembur' => $request->jam_lembur,
            'tanggal' => $request->tanggal,
            'status' => 'pending',
        ]);

        return redirect()->route('lembur.index')->with('success', 'Overtime request successfully submitted.');
    }

    public function edit($user_id, $tanggal)
    {
        $lembur = Lembur::where('user_id', $user_id)
                        ->where('tanggal', $tanggal)
                        ->firstOrFail();
        $users = User::all();
        return view('lembur.edit', compact('lembur', 'users'));
    }

    // Update Lembur
    public function update(Request $request, $user_id, $tanggal)
    {
        $request->validate([
            'jam_lembur' => 'required|integer',
            'tanggal' => 'required|date',
        ]);

        // Update data yang sudah ada berdasarkan primary key (user_id, tanggal)
        Lembur::where('user_id', $user_id)
              ->where('tanggal', $tanggal)
              ->update([
                  'jam_lembur' => $request->jam_lembur,
                  'tanggal' => $request->tanggal, // Jika tanggal boleh diubah, ini bisa ditambahkan
                  'status' => 'pending', // Ambil status lama jika perlu
              ]);
    
        return redirect()->route('lembur.index')->with('success', 'Overtime data successfully updated.');
    }
}
