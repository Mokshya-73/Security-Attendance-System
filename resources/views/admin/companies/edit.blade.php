@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">
     <div class="border-4 border-blue-900 rounded-2xl p-6 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">
    <h1 class="text-2xl font-bold text-blue-800 mb-6">Edit Company</h1>

    <form action="{{ route('admin.companies.update', $company->id) }}" method="POST" 
          class="bg-white p-6 shadow rounded-lg border border-blue-200">
        @csrf
        @method('PUT')

        <!-- Grid layout for two columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">BRN</label>
                    <input type="text" name="brn" value="{{ $company->brn }}" class="w-full mt-1 border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Company Name</label>
                    <input type="text" name="name" value="{{ $company->name }}" class="w-full mt-1 border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Contact Person</label>
                    <input type="text" name="contact_person" value="{{ $company->contact_person }}" class="w-full mt-1 border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ $company->email }}" class="w-full mt-1 border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ $company->phone }}" class="w-full mt-1 border rounded px-3 py-2">
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Address</label>
                    <input type="text" name="address" value="{{ $company->address }}" class="w-full mt-1 border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Website</label>
                    <input type="text" name="website" value="{{ $company->website }}" class="w-full mt-1 border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">License Number</label>
                    <input type="text" name="license_number" value="{{ $company->license_number }}" class="w-full mt-1 border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">License Expiry Date</label>
                    <input type="date" name="license_expiry" value="{{ $company->license_expiry }}" class="w-full mt-1 border rounded px-3 py-2">
                </div>
            </div>
        </div>

       <div class="flex justify-between items-center mt-4">
  <!-- Back button on left -->
 <a href="{{ route('admin.dashboard') }}" 
               class="group relative inline-block text-blue-800 font-semibold px-4 py-2 hover:text-blue-600 focus:outline-none">
   ← Back
                <span class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600 scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
</a>
            <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800 transition-colors">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
