@extends('layouts.app')
@section('styles')
    <style>
        .error-message {
            font-size: 10px;
            color: red
        }
    </style>
@endsection
@section('content')
    <form method="POST" action="{{ route('data') }}">
        @csrf
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" />
        @error('name')
            <p class="error-message">{{ $message }}</p>
        @enderror
        <label>Email</label>
        <input type="text" name="email" value="{{ old('email') }}" />
        @error('email')
            <p class="error-message">{{ $message }}</p>
        @enderror
        <label>Password</label>
        <input type="text" name="password" value="{{ old('password') }}" />
        @error('password')
            <p class="error-message">{{ $message }}</p>
        @enderror
        <button type="submit" class="btn">Submit</button>

    </form>
@endsection
