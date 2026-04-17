@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4">Forgot Password</h2>

    @if (session('status'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="email" name="email" placeholder="Your Email" required class="w-full border p-2 rounded mb-4">
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Send Reset Link</button>
    </form>
</div>
@endsection
