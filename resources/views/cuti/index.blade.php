@extends('layouts.app')

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h3 class="text-center mb-4">Leave Requests</h3>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Leave Type</th>
                    <th>Submission Type</th>
                    <th>Leave Date</th>
                    <th>Status</th>
                    @if(Auth::user()->role === 'Admin')
                        <th>Admin Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($cutis as $cuti)
                    @php
                        $jenisLabels = [
                            'cuti_tahunan' => 'Annual Leave',
                            'cuti_sakit' => 'Sick Leave',
                            'cuti_melahirkan' => 'Maternity Leave',
                            'cuti_penting' => 'Emergency Leave',
                        ];
                        $labelStatus = match($cuti->status) {
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default => 'warning',
                        };
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cuti->user->nama }}</td>
                        <td>{{ $jenisLabels[$cuti->jenis_cuti] ?? $cuti->jenis_cuti }}</td>
                        <td>
                            @php
                                $tipeLabels = [
                                    'satu_hari' => '1 Day',
                                    'dua_hari' => '2 Days',
                                    'tiga_hari' => '3 Days',
                                    'empat_hari' => '4 Days',
                                    'lima_hari' => '5 Days',
                                    'enam_hari' => '6 Days',
                                    'tujuh_hari' => '7 Days',
                                ];
                            @endphp
                            {{ $tipeLabels[$cuti->tipe_pengajuan] ?? ucfirst(str_replace('_', ' ', $cuti->tipe_pengajuan)) }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($cuti->tanggal)->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $labelStatus }}">
                                {{ ucfirst($cuti->status) }}
                            </span>
                        </td>
                        @if(Auth::user()->role === 'Admin')
                        <td>
                            @if($cuti->status === 'pending')
                                <form action="{{ route('cuti.approve', ['user_id' => $cuti->user_id, 'jenis_cuti' => $cuti->jenis_cuti, 'tanggal' => $cuti->tanggal]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                                <form action="{{ route('cuti.reject', ['user_id' => $cuti->user_id, 'jenis_cuti' => $cuti->jenis_cuti, 'tanggal' => $cuti->tanggal]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-warning">Reject</button>
                                </form>
                            @else
                                <em>No action</em>
                            @endif
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(Auth::user()->role === 'Admin')
            <a href="{{ route('cuti.create') }}" class="btn btn-primary mt-3">Add Leave Request</a>
        @endif
        @if(Auth::user()->role === 'Karyawan')
        <div class="mb-4">
            <a href="{{ route('cuti.create') }}" class="btn btn-primary">Request Leave</a>
        </div>
        @endif
    </div>
</div>
@endsection
