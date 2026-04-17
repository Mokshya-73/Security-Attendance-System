@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">
    <div class="border-4 border-blue-900 rounded-2xl p-6 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">
        <h1 class="text-2xl font-bold text-blue-800 mb-4">+ Add Patrol Officer</h1>

        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
            <ul class="text-sm list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.patrol_officers.store') }}" method="POST"
              class="bg-white p-6 shadow rounded-lg border border-blue-200">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full mt-1 border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- SLT Employee ID -->
            <div class="mb-4">
                <label for="slt_employee_id" class="block font-medium text-sm text-gray-700">SLT Employee ID</label>
                <input type="text" name="slt_employee_id" value="{{ old('slt_employee_id') }}"
                       class="w-full mt-1 border rounded px-3 py-2 @error('slt_employee_id') border-red-500 @enderror" required>
                @error('slt_employee_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div class="mb-4">
                <label for="location_id" class="block text-sm font-medium text-gray-700">Location</label>
                <select name="location_id"
                        class="w-full border rounded px-3 py-2 @error('location_id') border-red-500 @enderror" required>
                    <option value="">-- Select Location --</option>
                    @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                        {{ $location->name }}
                    </option>
                    @endforeach
                </select>
                @error('location_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Assigned Security Manager -->
            <div class="mb-4">
                <label for="assigned_manager_id" class="block font-medium text-sm text-gray-700">Security Manager</label>
                <select name="assigned_manager_id"
                        class="w-full mt-1 border rounded px-3 py-2 @error('assigned_manager_id') border-red-500 @enderror" required>
                    <option value="">-- Select Manager --</option>
                    @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" {{ old('assigned_manager_id') == $manager->id ? 'selected' : '' }}>
                        {{ $manager->name }}
                    </option>
                    @endforeach
                </select>
                @error('assigned_manager_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                <input type="password" name="password"
                       class="w-full mt-1 border rounded px-3 py-2 @error('password') border-red-500 @enderror" required>
                @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('admin.dashboard') }}"
                   class="group relative inline-block text-blue-800 font-semibold px-4 py-2 hover:text-blue-600 focus:outline-none">
                    ← Back
                    <span class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600 scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
                </a>

                <button type="submit"
                        class="bg-blue-800 text-white px-6 py-2 rounded hover:bg-blue-500 transition-colors">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
