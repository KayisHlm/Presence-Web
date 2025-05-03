@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">
            Welcome, {{ Auth::user()->nama }}!
        </h2>
    </div>
@endsection
