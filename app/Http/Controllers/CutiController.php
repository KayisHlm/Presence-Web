<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CutiController extends Controller
{
    // Tampilkan form pengajuan cuti (untuk Admin dan Karyawan)
    public function create()
    {
        $users = User::all(); // Untuk Admin memilih user
        return view('cuti.create', compact('users'));
    }

    // Simpan pengajuan cuti
// Menyimpan pengajuan cuti
public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'user_id' => 'required|exists:user_login,id',  // Menyesuaikan dengan tabel yang benar 'users'
        'jenis_cuti' => 'required|string',
        'tipe_pengajuan' => 'required|string',
        'tanggal' => 'required|date',
    ]);

    // Tentukan user_id berdasarkan peran
    $user_id = Auth::user()->role === 'Admin' ? $validated['user_id'] : Auth::id(); // Mengambil ID karyawan jika bukan admin

    // Simpan data cuti
    Cuti::create([
        'user_id' => $user_id,
        'jenis_cuti' => $validated['jenis_cuti'],
        'tipe_pengajuan' => $validated['tipe_pengajuan'],
        'tanggal' => $validated['tanggal'],
        'status' => 'pending',  // Status default adalah pending
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('cuti.index')->with('success', 'Leave request submitted successfully!');
}

    
    // Tampilkan semua data cuti
    public function index()
    {
        if (Auth::user()->role === 'Admin') {
            // Admin can see all leave requests
            $cutis = Cuti::all();
        } else {
            // Karyawan only sees their own leave requests
            $cutis = Cuti::where('user_id', Auth::user()->id)->get();
        }
        
        return view('cuti.index', compact('cutis'));
    }
    
    
    // Approve pengajuan cuti
    public function approve($user_id, $jenis_cuti, $tanggal)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('cuti.index')->with('error', 'You do not have the right to perform this action.');
        }

        Cuti::where('user_id', $user_id)
            ->where('jenis_cuti', $jenis_cuti)
            ->where('tanggal', $tanggal)
            ->update(['status' => 'approved']);

        return redirect()->route('cuti.index')->with('success', 'Leave successfully approved');
    }

    // Reject pengajuan cuti
    public function reject($user_id, $jenis_cuti, $tanggal)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('cuti.index')->with('error', 'You do not have the right to perform this action.');
        }

        Cuti::where('user_id', $user_id)
            ->where('jenis_cuti', $jenis_cuti)
            ->where('tanggal', $tanggal)
            ->update(['status' => 'rejected']);

        return redirect()->route('cuti.index')->with('success', 'Leave was successfully rejected');
    }

}
