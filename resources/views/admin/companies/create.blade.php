@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">
     <div class="border-4 border-blue-900 rounded-2xl p-6 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">
    <h1 class="text-2xl font-bold text-blue-800 mb-4">+ Add Company</h1>

    <form action="{{ route('admin.companies.store') }}" method="POST" class="bg-white p-6 shadow rounded-lg border border-blue-200">
        @csrf

        <!-- 2-column responsive grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6">
            <!-- LEFT COLUMN -->
            <div>
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">BRN</label>
                    <input type="text" name="brn" value="{{ old('brn') }}" class="w-full mt-1 border rounded px-3 py-2" required>
                    @error('brn') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Company Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full mt-1 border rounded px-3 py-2" required>
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Contact Person</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" class="w-full mt-1 border rounded px-3 py-2" required>
                    @error('contact_person') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full mt-1 border rounded px-3 py-2">
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full mt-1 border rounded px-3 py-2">
                    @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div>
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" class="w-full mt-1 border rounded px-3 py-2">
                    @error('address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Website</label>
                    <input type="text" name="website" value="{{ old('website') }}" class="w-full mt-1 border rounded px-3 py-2">
                    @error('website') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">License Number</label>
                    <input type="text" name="license_number" value="{{ old('license_number') }}" class="w-full mt-1 border rounded px-3 py-2">
                    @error('license_number') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">License Expiry Date</label>
                    <input type="date" name="license_expiry" value="{{ old('license_expiry') }}" class="w-full mt-1 border rounded px-3 py-2">
                    @error('license_expiry') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div><!-- /grid -->

<div class="flex justify-between items-center mt-4">
  <!-- Back button on left -->
 <a href="{{ route('admin.dashboard') }}" 
               class="group relative inline-block text-blue-800 font-semibold px-4 py-2 hover:text-blue-600 focus:outline-none">
   ← Back
                <span class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600 scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
</a>


  <!-- Create button on right -->
  <button type="submit" class="bg-blue-800 text-white px-6 py-2 rounded hover:bg-blue-500 transition-colors">
      Create
  </button>
</div>



    </form>
</div>
@endsection
