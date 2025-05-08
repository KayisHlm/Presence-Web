@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3 class="text-center mb-4">Overtime Data</h3>
    
    <table class="table table-striped table-hover table-bordered shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Overtime Hour</th>
                <th>Hourly Wage</th>
                <th>Total Overtime Pay</th>
                <th>Date</th>
                <th>Status</th>
                @if(auth()->user()->role === 'Admin')
                <th>Admin Action</th>
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($lemburs as $lembur)
                @php
                    $gajiPerJam = $lembur->user->gaji / 165;
                    $totalGajiLembur = $gajiPerJam * $lembur->jam_lembur;
                @endphp
                <tr>
                    <td>{{ $lembur->user->nama }}</td>
                    <td>{{ $lembur->user->posisi }}</td>
                    <td>
                        @if($lembur->jam_lembur == 1)
                            {{ $lembur->jam_lembur }} Hour
                        @else
                            {{ $lembur->jam_lembur }} Hours
                        @endif
                    </td>
                    <td>Rp {{ number_format($gajiPerJam, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($totalGajiLembur, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($lembur->tanggal)->format('d M Y') }}</td>
                    <td>
                        <span class="badge bg-{{ $lembur->status == 'approved' ? 'success' : ($lembur->status == 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($lembur->status) }}
                        </span>
                    </td>
                    @if(auth()->user()->role === 'Admin')
                    <td>
                        @if($lembur->status == 'pending')
                        <form action="{{ route('lembur.approve', [$lembur->user_id, $lembur->tanggal]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-success">Approve</button>
                        </form>
                        <form action="{{ route('lembur.reject', [$lembur->user_id, $lembur->tanggal]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-warning">Reject</button>
                        </form>
                        @endif
                    </td>
                    <td>
                            <a href="{{ route('lembur.edit', [$lembur->user_id, $lembur->tanggal]) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('lembur.destroy', [$lembur->user_id, $lembur->tanggal]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data lembur ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('lembur.create') }}" class="btn btn-primary mb-3">Add Overtime</a>
        </div>
        @endsection
