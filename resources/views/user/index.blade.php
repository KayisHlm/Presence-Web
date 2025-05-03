@extends('layouts.app')

@section('content')
    <div class="container py-5">
      <h3 class="text-center mb-4">User Data</h3>
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered shadow-sm">
          <thead class="table-dark">
            <tr>
              <th scope="col" align="center">#</th>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Position</th>
              <th scope="col">Base Salary</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $user->id }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->posisi}}</td>
                <td>Rp {{ number_format($user->gaji, 0, ',', '.') }}</td>
                <td>
                  <form action="{{ route('user.destroy', $user->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <a href="{{ route('user.edit', $user->id) }}" type="button" class="btn btn-warning">Edit</a>
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
                </td>
              </tr> 
            @endforeach
          </tbody>
        </table>
      </div>
      <a href="{{ route(name: 'user.add') }}" class="btn btn-primary">Add User</a>
    </div>

@endsection