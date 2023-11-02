@extends('layouts.app')
@section('styles')
    <style>
        .error-message {
            font-size: 10px;
            color: red
        }

        .btn {
            @apply rounded-md px-1 py-1 text-center font-medium text-slate-700 shadow-sm ring-1 ring-slate-700/10
        }

        .link {
            @apply font-medium text-gray-700 underline decoration-pink-500
        }

        label {
            @apply block mb-4 text-slate-700 upercase
        }

        input {
            @apply mb-4 shadow-sm appearance-none width-full py-2 px-1 text-slate-700 leading-tight
        }
    </style>
@endsection
@section('content')
    <div class="mb-10 border rounded border-green-400 bg-green-100 px-4 py-3 text-lg text-green-700">
        <strong class="font-bold">Success!</strong>
        <div>This is a flash message.</div>
    </div>
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
