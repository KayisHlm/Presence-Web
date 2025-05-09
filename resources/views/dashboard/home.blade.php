@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">
            @if(Auth::check())
                Welcome, 
                @if(Auth::user()->role === 'admin')
                    Admin!
                @else
                    {{ Auth::user()->nama }}!
                @endif
            @else
                Welcome, Guest!
            @endif
        </h2>
    </div>
@endsection
