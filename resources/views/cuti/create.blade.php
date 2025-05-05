@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3 class="text-center mb-4">Create Leave Request</h3>

    <form action="{{ route('cuti.store') }}" method="POST">
        @csrf
    
        @if (Auth::user()->role === 'Admin')
            <div class="mb-3">
                <label for="user_id" class="form-label">Select User</label>
                <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                    <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Choose a user</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
        @else
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        @endif
    
        <div class="mb-3">
            <label for="jenis_cuti" class="form-label">Leave Type</label>
            <select name="jenis_cuti" id="jenis_cuti" class="form-control @error('jenis_cuti') is-invalid @enderror">
                <option value="" disabled {{ old('jenis_cuti') ? '' : 'selected' }}>Select leave type</option>
                <option value="cuti_tahunan" {{ old('jenis_cuti') == 'cuti_tahunan' ? 'selected' : '' }}>Annual Leave</option>
                <option value="cuti_sakit" {{ old('jenis_cuti') == 'cuti_sakit' ? 'selected' : '' }}>Sick Leave</option>
                <option value="cuti_melahirkan" {{ old('jenis_cuti') == 'cuti_melahirkan' ? 'selected' : '' }}>Maternity Leave</option>
                <option value="cuti_penting" {{ old('jenis_cuti') == 'cuti_penting' ? 'selected' : '' }}>Emergency Leave</option>
            </select>
            @error('jenis_cuti')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="mb-3">
            <label for="tipe_pengajuan" class="form-label">Submission Type</label>
            <select name="tipe_pengajuan" id="tipe_pengajuan" class="form-control @error('tipe_pengajuan') is-invalid @enderror">
                <option value="" disabled {{ old('tipe_pengajuan') ? '' : 'selected' }}>Select submission type</option>
                <option value="satu_hari" {{ old('tipe_pengajuan') == 'satu_hari' ? 'selected' : '' }}>A Day</option>
                <option value="dua_hari" {{ old('tipe_pengajuan') == 'dua_hari' ? 'selected' : '' }}>Two Days</option>
                <option value="tiga_hari" {{ old('tipe_pengajuan') == 'tiga_hari' ? 'selected' : '' }}>Three Days</option>
                <option value="empat_hari" {{ old('tipe_pengajuan') == 'empat_hari' ? 'selected' : '' }}>Four Days</option>
                <option value="lima_hari" {{ old('tipe_pengajuan') == 'lima_hari' ? 'selected' : '' }}>Five Days</option>
                <option value="enam_hari" {{ old('tipe_pengajuan') == 'enam_hari' ? 'selected' : '' }}>Six Days</option>
                <option value="tujuh_hari" {{ old('tipe_pengajuan') == 'tujuh_hari' ? 'selected' : '' }}>Seven Days</option>
            </select>
            @error('tipe_pengajuan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="mb-3">
            <label for="tanggal" class="form-label">Leave Date</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
</div>
@endsection
