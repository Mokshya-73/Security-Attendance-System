@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">
    <div class="border-4 border-blue-900 rounded-2xl p-4 sm:p-6 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">
        <h1 class="text-lg sm:text-2xl font-bold text-blue-800 mb-4">+ Add Security Officer</h1>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded text-sm sm:text-base">
                <strong>There were some problems with your input:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Start -->
        <form action="{{ route('admin.security_officers.store') }}" method="POST" enctype="multipart/form-data" 
              class="bg-white p-4 sm:p-6 shadow rounded-lg border border-blue-200">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Title -->
                <div>
                    <label for="title_id" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <select name="title_id" id="title_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        <option value="">-- Select Title --</option>
                        @foreach($titles as $title)
                            <option value="{{ $title->id }}" {{ old('title_id') == $title->id ? 'selected' : '' }}>
                                {{ $title->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('title_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Name -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                           value="{{ old('name') }}" required>
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- NIC -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-1">NIC</label>
                    <input type="text" name="nic" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                           value="{{ old('nic') }}" required>
                    @error('nic') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Service Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Number</label>
                    <input type="text" name="service_no_input" value="{{ old('service_no_input') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="e.g. 1283214" required>
                    <p class="text-xs text-gray-500 mt-1">System will generate service number like AG/1283214 based on company.</p>
                    @error('service_no_input') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-1">Phone</label>
                    <input type="text" name="telephone" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                           value="{{ old('telephone') }}" required>
                    @error('telephone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                           value="{{ old('address') }}" required>
                    @error('address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Company -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-1">Company</label>
                    <select name="company_id" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
                        <option value="">-- Select Company --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Patrol Officer -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-1">Patrol Officer</label>
                    <select name="assigned_patrol_id" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
                        <option value="">-- Select Patrol --</option>
                        @foreach($patrols as $patrol)
                            <option value="{{ $patrol->id }}" {{ old('assigned_patrol_id') == $patrol->id ? 'selected' : '' }}>
                                {{ $patrol->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_patrol_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- NIC Front -->
                <div class="md:col-span-2">
                    <label class="block font-medium text-sm text-gray-700 mb-1">NIC Front Photo</label>
                    <input type="file" name="nic_photo_front" accept="image/*" class="w-full border rounded px-3 py-2">
                    @error('nic_photo_front') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- NIC Back -->
                <div class="md:col-span-2">
                    <label class="block font-medium text-sm text-gray-700 mb-1">NIC Back Photo</label>
                    <input type="file" name="nic_photo_back" accept="image/*" class="w-full border rounded px-3 py-2">
                    @error('nic_photo_back') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-3">
                <a href="{{ route('admin.dashboard') }}" 
                   class="text-blue-800 font-semibold hover:text-blue-600 transition text-sm sm:text-base">
                    ← Back
                </a>
                <button type="submit" 
                        class="bg-blue-800 text-white px-6 py-2 rounded hover:bg-blue-600 transition-colors w-full sm:w-auto">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
