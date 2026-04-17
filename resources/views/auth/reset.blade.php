@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4">Reset Password</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <input type="email" name="email" placeholder="Your Email" required class="w-full border p-2 rounded mb-4">
        <input type="password" name="password" placeholder="New Password" required class="w-full border p-2 rounded mb-4">
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="w-full border p-2 rounded mb-4">

        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Reset Password</button>
    </form>
</div>
@endsection
