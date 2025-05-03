@extends('layouts.app')

@section('content')
    <div class="container py-5">
      <h3 class="text-center mb-4">User Data</h3>
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered shadow-sm">
          <thead class="table-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Position</th>
              <th scope="col">Base Salary</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->posisi}}</td>
                <td>Rp {{ number_format($user->gaji, 0, ',', '.') }}</td>
              </tr> 
          </tbody>
        </table>

@endsection