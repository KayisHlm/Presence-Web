@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<div class="container">
    <h3 class="text-center mb-4">Edit Employee Attendance</h3>

    <form action="{{ route('absen.update', $absen->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="text" name="user_id" id="user_id" class="form-control" value="{{ $absen->user_id }}" readonly>
        </div>

        <div class="mb-3">
            <label>Employee Name</label>
            <input type="text" class="form-control" value="{{ $absen->user->nama }}" readonly>
            <input type="hidden" name="user_id" value="{{ $absen->user_id }}">
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $absen->tanggal }}">
        </div>

        <div class="mb-3">
            <label>Check-In Time</label>
            <input type="time" name="check_in" class="form-control" value="{{ $absen->check_in }}">
        </div>

        <div class="mb-3">
            <label>Check-Out Time</label>
            <input type="time" name="check_out" class="form-control" value="{{ $absen->check_out }}">
        </div>

        <div class="mb-4">
            <h5>Check-In Location</h5>
            <div id="map-checkin" style="height: 300px;"></div>
        </div>

        <div class="mb-4">
            <h5>Check-Out Location</h5>
            <div id="map-checkout" style="height: 300px;"></div>
        </div>


        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Hadir" {{ $absen->status == 'Hadir' ? 'selected' : '' }}>Attended</option>
                <option value="Izin" {{ $absen->status == 'Izin' ? 'selected' : '' }}>Permission</option>
                <option value="Sakit" {{ $absen->status == 'Sakit' ? 'selected' : '' }}>Sick</option>
                <option value="Tidak Hadir" {{ $absen->status == 'Tidak Hadir' ? 'selected' : '' }}>Absent</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('absen.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
    var latIn = {{ $absen->lokasi_latitude_in ?? 0 }};
    var lonIn = {{ $absen->lokasi_longitude_in ?? 0 }};
    var latOut = {{ $absen->lokasi_latitude_out ?? 0 }};
    var lonOut = {{ $absen->lokasi_longitude_out ?? 0 }};

    var mapCheckIn = L.map('map-checkin').setView([latIn, lonIn], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(mapCheckIn);
    L.marker([latIn, lonIn]).addTo(mapCheckIn)
        .bindPopup("Check-In Location").openPopup();

    var mapCheckOut = L.map('map-checkout').setView([latOut, lonOut], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(mapCheckOut);
    L.marker([latOut, lonOut]).addTo(mapCheckOut)
        .bindPopup("Check-Out Location").openPopup();
</script>

@endsection
