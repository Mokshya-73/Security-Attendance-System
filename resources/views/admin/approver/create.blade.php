@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">
    <div class="border-4 border-blue-900 rounded-2xl p-6 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">
        <h1 class="text-2xl font-bold text-blue-800 mb-4">+ Add Approver</h1>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="mb-4 p-4 rounded bg-red-100 border border-red-400 text-red-700">
                <strong>Whoops! Something went wrong:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.approver.store') }}" method="POST" class="bg-white p-6 shadow rounded-lg border border-blue-200">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full mt-1 border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="employee_id" class="block font-medium text-sm text-gray-700">Employee ID</label>
                <input type="text" name="employee_id" value="{{ old('employee_id') }}"
                       class="w-full mt-1 border rounded px-3 py-2 @error('employee_id') border-red-500 @enderror" required>
                @error('employee_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                <input type="password" name="password"
                       class="w-full mt-1 border rounded px-3 py-2 @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-4">
                <!-- Back button -->
                <a href="{{ route('admin.dashboard') }}"
                   class="group relative inline-block text-blue-800 font-semibold px-4 py-2 hover:text-blue-600 focus:outline-none">
                    ← Back
                    <span class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600 scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
                </a>

                <!-- Submit button -->
                <button type="submit" class="bg-blue-800 text-white px-6 py-2 rounded hover:bg-blue-500 transition-colors">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
