@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3 class="text-center mb-4">Salary Data</h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Bonus</th>
                    <th>Deduction</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gajis as $gaji)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $gaji->user->nama }}</td>
                    <td>{{ $gaji->user->posisi }}</td>
                    <td>Rp {{ number_format($gaji->bonus, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($gaji->deduction, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($gaji->tanggal)->format('d F Y') }}</td>
                    <td>
                        @if(Auth::user()->role === 'Admin')
                        <form action="{{ route('gaji.destroy', $gaji->user_id) }}" method="POST" class="d-inline">
                            @csrf
                                @method('DELETE')
                                <a href="{{ route('gaji.edit', $gaji->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</button>
                            </form>
                            <a href="{{ route('gaji.download', $gaji->user_id) }}" class="btn btn-success btn-sm">Download Slip</a>
                            @else
                        <a href="{{ route('gaji.download', $gaji->user_id) }}" class="btn btn-success btn-sm">Download Slip</a>
                        @endif
                    </td>                                
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if(Auth::user()->role === 'Admin')
    <a href="{{ route('gaji.create') }}" class="btn btn-primary">Add Salary</a>
    @endif

</div>
@endsection
