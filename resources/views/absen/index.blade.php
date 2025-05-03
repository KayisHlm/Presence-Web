@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3 class="text-center mb-4">Attendance Data</h3>
    
    <table class="table table-striped table-hover table-bordered shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
                @if(auth()->user()->role === 'Admin')
                <th>Daily Rate</th>
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($groupedAbsens as $tanggal => $absensPerTanggal)
            <tr class="table-secondary">
                <td colspan="{{ auth()->user()->role === 'Admin' ? '7' : '5' }}">
                    <strong>Date: {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</strong>
                </td>
            </tr>
            
            @foreach($absensPerTanggal as $absen)
            <tr>
                <td>{{ $absen->user->nama ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}</td>
                <td>{{ $absen->check_in ? $absen->check_in . ' WIB' : '-' }}</td>
                <td>{{ $absen->check_out ? $absen->check_out . ' WIB' : '-' }}</td>
                <td>
                    @switch($absen->status)
                        @case('Hadir')
                            Attended
                            @break
                
                        @case('Izin')
                            Permission
                            @break
                
                        @case('Sakit')
                            Sick
                            @break
                
                        @default
                            Absent
                    @endswitch
                </td>                
                
                @if(auth()->user()->role === 'Admin')
                @php
                                $tanggal = \Carbon\Carbon::parse($absen->tanggal);
                                $hariDalamBulan = $tanggal->daysInMonth;
                                
                                $startOfMonth = $tanggal->copy()->startOfMonth();
                                $endOfMonth = $tanggal->copy()->endOfMonth();
                                $weekends = 0;
                                
                                for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
                                    if ($date->isWeekend()) $weekends++;
                                }
                                
                                $hariKerja = max(1, $hariDalamBulan - $weekends);
                                $dailyRate = ($absen->status === 'Hadir') ? ($absen->user->gaji / $hariKerja) : 0;
                            @endphp
                            <td>Rp {{ number_format($dailyRate, 0, ',', '.') }}</td>
                            <td>
                                @if(!is_null($absen->id))
                                <a href="{{ route('absen.edit', $absen->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('absen.destroy', $absen->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('absen.create') }}" class="btn btn-primary mb-3">Add Attendance</a>
            </div>
            @endsection
