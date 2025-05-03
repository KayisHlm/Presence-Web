@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Overtime Data</h1>
    <form action="{{ route('lembur.update', ['user_id' => $lembur->user_id, 'tanggal' => $lembur->tanggal]) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label>Employee Name</label>
            <input type="text" class="form-control" value="{{ $lembur->user->nama }}" readonly>
        </div>

        <div class="mb-3">
            <label for="jam_lembur">Overtime Hour</label>
            <input type="number" name="jam_lembur" value="{{ $lembur->jam_lembur }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tanggal">Date</label>
            <input type="date" name="tanggal" value="{{ $lembur->tanggal }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
