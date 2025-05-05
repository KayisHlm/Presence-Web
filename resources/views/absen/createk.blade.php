@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center mb-4">Attendance Form</h3>

    <div class="mb-4">
        <button class="btn btn-primary" onclick="setMode('checkin')">Check In</button>
        <button class="btn btn-warning" onclick="setMode('checkout')">Check Out</button>
    </div>

    <form id="absenForm" method="POST" action="">
        @csrf
        <input type="hidden" name="mode" id="mode" value="checkin">
        <input type="hidden" name="_method" id="formMethod" value="POST">

        <div class="mb-3">
            <label>Employee Name</label>
            <select name="user_id" class="form-control" required readonly>
                <option value="{{ $user->id }}">{{ $user->nama }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="tanggal" class="form-control" readonly>
        </div>

        <div class="mb-3" id="checkin-time-group">
            <label>Check-In Time</label>
            <input type="time" name="check_in" class="form-control" readonly>
        </div>

        <div class="mb-3" id="checkout-time-group" style="display: none;">
            <label>Check-Out Time</label>
            <input type="time" name="check_out" class="form-control" readonly>
        </div>

        <div class="mb-3" id="latitude-in">
            <input type="hidden" name="lokasi_latitude_in" id="lokasi_latitude_in" class="form-control" readonly>
        </div>

        <div class="mb-3" id="latitude-out" style="display: none;">
            <input type="hidden" name="lokasi_latitude_out" id="lokasi_latitude_out" class="form-control" readonly>
        </div>

        <div class="mb-3" id="longitude-in">
            <input type="hidden" name="lokasi_longitude_in" id="lokasi_longitude_in" class="form-control" readonly>
        </div>

        <div class="mb-3" id="longitude-out" style="display: none;">
            <input type="hidden" name="lokasi_longitude_out" id="lokasi_longitude_out" class="form-control" readonly>
        </div>

{{-- Status diatur otomatis di controller --}}
<input type="hidden" name="status" value="">


        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>

<script>
    function setMode(mode) {
        document.getElementById('mode').value = mode;

        const isCheckIn = mode === 'checkin';
        document.getElementById('checkin-time-group').style.display = isCheckIn ? 'block' : 'none';
        document.getElementById('checkout-time-group').style.display = isCheckIn ? 'none' : 'block';
        document.getElementById('latitude-in').style.display = isCheckIn ? 'block' : 'none';
        document.getElementById('longitude-in').style.display = isCheckIn ? 'block' : 'none';
        document.getElementById('latitude-out').style.display = isCheckIn ? 'none' : 'block';
        document.getElementById('longitude-out').style.display = isCheckIn ? 'none' : 'block';

        const form = document.getElementById('absenForm');
        const userId = "{{ $user->id }}";
        const today = new Date().toISOString().split('T')[0];

        if (mode === 'checkin') {
    form.action = "{{ route('absen.checkin') }}";
    document.getElementById('formMethod').value = 'POST';
} else {
    form.action = "{{ route('absen.checkout', ['id' => $user->id]) }}";
    document.getElementById('formMethod').value = 'PUT';
}


        setCurrentDateTime();
        getLocation();
    }

    function setCurrentDateTime() {
        const today = new Date();

        const tanggal = today.getFullYear() + '-' +
                        String(today.getMonth() + 1).padStart(2, '0') + '-' +
                        String(today.getDate()).padStart(2, '0');
        document.querySelector('input[name="tanggal"]').value = tanggal;

        const waktu = String(today.getHours()).padStart(2, '0') + ':' +
                      String(today.getMinutes()).padStart(2, '0');

        if (document.getElementById('mode').value === 'checkin') {
            document.querySelector('input[name="check_in"]').value = waktu;
        } else {
            document.querySelector('input[name="check_out"]').value = waktu;
        }
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                if (document.getElementById('mode').value === 'checkin') {
                    document.getElementById('lokasi_latitude_in').value = position.coords.latitude;
                    document.getElementById('lokasi_longitude_in').value = position.coords.longitude;
                } else {
                    document.getElementById('lokasi_latitude_out').value = position.coords.latitude;
                    document.getElementById('lokasi_longitude_out').value = position.coords.longitude;
                }
            }, function(error) {
                alert('Gagal mengambil lokasi: ' + error.message);
            });
        } else {
            alert('Browser tidak mendukung GPS');
        }
    }

    window.onload = function() {
        setMode('checkin');
    }
</script>
@endsection
