<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class GajiController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'Karyawan') {
            $gajis = Gaji::with('user')
                        ->where('user_id', Auth::id())
                        ->get();
        } else {
            $gajis = Gaji::with('user')->get();
        }
    
        return view('gaji.index', compact('gajis'));
    }
    public function download($user_id)
    {
        $gaji = Gaji::where('user_id', $user_id)->firstOrFail();
    
        if (Auth::user()->role === 'Karyawan' && Auth::id() !== $gaji->user_id) {
            abort(403);
        }
    
        $pdf = Pdf::loadView('gaji.slip', compact('gaji'));
        return $pdf->download('Slip-Gaji-' . $gaji->tanggal . '.pdf');
    }

    public function create()
    {
        $users = User::all();
        return view('gaji.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'bonus' => 'required',
            'deduction' => 'required',
            'tanggal' => 'required',
        ]);
    
        // Save the data with raw numeric values
        Gaji::create([
            'user_id' => $request->user_id,
            'bonus' => $request->bonus,  // Use raw bonus value
            'deduction' => $request->deduction,  // Use raw deduction value
            'tanggal' => $request->tanggal,
        ]);
        return redirect()->route('gaji.index');
    }
    

    public function edit($user_id)
    {
        $gaji = Gaji::where('user_id', $user_id)->firstOrFail();
        $users = User::all();
        return view('gaji.edit', compact('gaji', 'users'));
    }
    public function update(Request $request, Gaji $gaji)
    {
        $request->validate([
            'bonus' => 'required',
            'deduction' => 'required',
            'tanggal' => 'required',
        ]);
    
        $gaji->update($request->only('bonus', 'deduction', 'tanggal'));

        return redirect()->route('gaji.index')->with('success', 'Salary data successfully updated.');
    }

    public function destroy($user_id)
    
    {
        $gaji = Gaji::where('user_id', $user_id)->firstOrFail();
        $gaji->delete();

        return redirect()->route('gaji.index')->with('success', 'Salary data successfully deleted.');
    }
    
    
}
