@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="text-center mb-4">Add Salary Data</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gaji.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">Employee Name</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Select Employee --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="bonus" class="form-label">Bonus</label>
            <input type="text" name="bonus" id="bonus" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="deduction" class="form-label">Deduction</label>
            <input type="text" name="deduction" id="deduction" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Date</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('gaji.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
      const bonusInput = document.getElementById('bonus');
      const deductionInput = document.getElementById('deduction');
    
      if (bonusInput) {
        bonusInput.addEventListener('input', function(e) {
          let angka = this.value.replace(/[^,\d]/g, '');
          let split = angka.split(',');
          let sisa = split[0].length % 3;
          let rupiah = split[0].substr(0, sisa);
          let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
          if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
          }
    
          rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
          this.value = rupiah ? 'Rp ' + rupiah : '';
        });
      }
    
      if (deductionInput) {
        deductionInput.addEventListener('input', function(e) {
          let angka = this.value.replace(/[^,\d]/g, '');
          let split = angka.split(',');
          let sisa = split[0].length % 3;
          let rupiah = split[0].substr(0, sisa);
          let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
          if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
          }
    
          rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
          this.value = rupiah ? 'Rp ' + rupiah : '';
        });
      }
    
      document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function () {
          if (bonusInput) {
            bonusInput.value = bonusInput.value.replace(/[^0-9]/g, '');
          }
          if (deductionInput) {
            deductionInput.value = deductionInput.value.replace(/[^0-9]/g, '');
          }
        });
      });
    });
    </script>
    
@endsection
