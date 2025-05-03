<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\User;
use Carbon\Carbon;

class AbsenController extends Controller
{
    public function index()
    {

        /** @var User $user */
        $user = Auth::user();    
        // Untuk Admin: ambil semua user dan tanggal unik
        if ($user->role === 'Admin') {
            $allUsers = User::all();
            $allDates = Absen::select('tanggal')->distinct()->pluck('tanggal');
        } else {
            // Untuk Karyawan: hanya ambil tanggal-tanggal milik dirinya
            $allUsers = collect([$user]);
            $allDates = Absen::where('user_id', $user->id)->select('tanggal')->distinct()->pluck('tanggal');
        }
    
        $finalAbsens = collect();
    
        foreach ($allDates as $tanggal) {
            foreach ($allUsers as $u) {
                $absen = Absen::where('user_id', $u->id)
                              ->whereDate('tanggal', $tanggal)
                              ->with('user')
                              ->first();
    
                              if ($absen) {
                                $finalAbsens->push($absen);
                            } else {
                                $dummy = new Absen([
                                    'user_id' => $u->id,
                                    'tanggal' => $tanggal,
                                    'check_in' => null,
                                    'check_out' => null,
                                    'status' => 'Tidak Hadir',
                                    'user' => $u
                                ]);
                                $dummy->exists = false;
                                $finalAbsens->push($dummy);
                            }
            }
        }
    
        $groupedAbsens = $finalAbsens->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('Y-m-d');
        });
    
        return view('absen.index', compact('groupedAbsens'));
    }
    
    
    public function create()
    {
        $user = Auth::user();
        if ($user->role === 'Admin') {
            $users = User::all();
            return view('absen.create', compact('users'));
        } else {
            return view('absen.createk', compact('user'));
        }
    }

    // ✅ CHECK IN (POST)
    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'tanggal' => 'required',
            'check_in' => 'required',
            'lokasi_latitude_in' => 'nullable',
            'lokasi_longitude_in' => 'nullable',
        ]);

        $alreadyCheckedIn = Absen::where('user_id', $validated['user_id'])
                                ->where('tanggal', $validated['tanggal'])
                                ->first();

        if ($alreadyCheckedIn) {
            return redirect()->back()->with('error', 'You have checked in today.');
        }

        Absen::create([
            'user_id' => $validated['user_id'],
            'tanggal' => $validated['tanggal'],
            'check_in' => $validated['check_in'],
            'lokasi_latitude_in' => $validated['lokasi_latitude_in'],
            'lokasi_longitude_in' => $validated['lokasi_longitude_in'],
        ]);

        return redirect()->route('absen.index')->with('success', 'Successfully check-in!');
    }

    // ✅ CHECK OUT (PUT)
    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'tanggal' => 'required',
            'check_out' => 'required',
            'lokasi_latitude_out' => 'nullable',
            'lokasi_longitude_out' => 'nullable',
        ]);
    
        $absen = Absen::where('user_id', $validated['user_id'])
                      ->where('tanggal', $validated['tanggal'])
                      ->first();
    
        if (!$absen) {
            return redirect()->back()->with('error', "Haven't checked in yet!");
        }
    
        // Hitung status otomatis berdasarkan waktu check out
        $jamCheckOut = Carbon::createFromFormat('H:i', $validated['check_out']);
        $batasSiang = Carbon::createFromTime(12, 0); // jam 12:00
    
        $status = $jamCheckOut->greaterThanOrEqualTo($batasSiang) ? 'Hadir' : 'Izin';
    
        $absen->update([
            'check_out' => $validated['check_out'],
            'lokasi_latitude_out' => $validated['lokasi_latitude_out'],
            'lokasi_longitude_out' => $validated['lokasi_longitude_out'],
            'status' => $status,
        ]);
    
        return redirect()->route('absen.index')->with('success', 'Successfully check-out!');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required',
        'tanggal' => 'required',
        'check_in' => 'nullable',
        'check_out' => 'nullable',
        'status' => 'required',
        'lokasi_latitude' => 'nullable',
        'lokasi_longitude' => 'nullable',
    ]);

    // Cek duplikat absen di tanggal yang sama
    $existing = Absen::where('user_id', $validated['user_id'])
                    ->where('tanggal', $validated['tanggal'])
                    ->first();

    if ($existing) {
        return redirect()->back()->with('error', 'Attendance data for that date already exists.');
    }

    Absen::create([
        'user_id' => $validated['user_id'],
        'tanggal' => $validated['tanggal'],
        'check_in' => $validated['check_in'],
        'check_out' => $validated['check_out'],
        'status' => $validated['status'],
        'lokasi_latitude_in' => $validated['lokasi_latitude'],
        'lokasi_longitude_in' => $validated['lokasi_longitude'],
    ]);

    return redirect()->route('absen.index')->with('success', 'Attendance data successfully added.');
}

    public function edit($id)
    {
        $absen = Absen::findOrFail($id);
        $users = User::all();
        return view('absen.edit', compact('absen', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'tanggal' => 'required',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'lokasi_latitude_in' => 'nullable',
            'lokasi_longitude_in' => 'nullable',
            'lokasi_latitude_out' => 'nullable',
            'lokasi_longitude_out' => 'nullable',
            'status' => 'required',
        ]);

        $absen = Absen::findOrFail($id);
        $absen->update($validated);

        return redirect()->route('absen.index')->with('success', 'Attendance data successfully updated.');
    }

    public function destroy($id)
    {
        $absen = Absen::findOrFail($id);
        $absen->delete();

        return redirect()->route('absen.index')->with('success', 'Attendance data successfully deleted.');
    }
}
