@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center mb-4">Add Overtime</h3>

    <form action="{{ route('lembur.store') }}" method="POST">
        @csrf

        @if(auth()->user()->role === 'Admin')
        <div class="mb-3">
            <label for="user_id" class="form-label">Employee Name</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Select employee --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->nama }} - {{ $user->posisi }}
                    </option>
                @endforeach
            </select>
        </div>
    @else
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
    
        <div class="mb-3">
            <label class="form-label">Employee Name</label>
            <input type="text" class="form-control" value="{{ auth()->user()->nama }}" readonly>
        </div>
    
        <div class="mb-3">
            <label class="form-label">Position</label>
            <input type="text" class="form-control" value="{{ auth()->user()->posisi }}" readonly>
        </div>
    @endif
    

        <div class="mb-3">
            <label for="jam_lembur">Overtime Hour</label>
            <input type="number" name="jam_lembur" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tanggal">Date</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <input type="hidden" name="status" value="pending">

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
<script>
    const select = document.getElementById('user_id');
    const posisiInput = document.getElementById('posisi');

    select.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const posisi = selected.getAttribute('data-posisi');
        posisiInput.value = posisi;
    });

    // trigger saat pertama kali
    select.dispatchEvent(new Event('change'));
</script>
@endsection