@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center mb-4">Add Employee Attendance</h3>
    <form action="{{ route('absen.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="user_id">Employee Name</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->nama }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="mb-3">
            <label for="tanggal">Date</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="check_in">Check-in</label>
            <input type="time" name="check_in" class="form-control">
        </div>
        
        <div class="mb-3">
            <label for="check_out">Check-out</label>
            <input type="time" name="check_out" class="form-control">
        </div>
        
        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="Hadir">Attended</option>
                <option value="Izin">Permission</option>
                <option value="Sakit">Sick</option>
                <option value="Sakit">Absent</option>
            </select>
        </div>
        
        <!-- Lokasi otomatis diisi dengan geolocation -->
        <input type="hidden" name="lokasi_latitude" id="lokasi_latitude">
        <input type="hidden" name="lokasi_longitude" id="lokasi_longitude">
        
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>

<script>
    window.onload = function() {
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(event) {
            event.preventDefault();
        
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementsByName('lokasi_latitude')[0].value = position.coords.latitude;
                    document.getElementsByName('lokasi_longitude')[0].value = position.coords.longitude;
                    
                    form.submit();
                }, function(error) {
                    alert('Gagal mengambil lokasi: ' + error.message);
                });
            } else {
                alert('Browser tidak mendukung GPS');
            }
        });
    };
</script>
    
@endsection
