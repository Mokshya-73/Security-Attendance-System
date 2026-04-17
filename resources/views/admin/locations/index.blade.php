@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold text-blue-800 mb-4">🏢 Manage Locations
</h1>

    <div class="border-4 border-blue-900 rounded-2xl p-6 sm:p-10 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

       <div class="flex justify-start mb-4">
    <a href="{{ route('admin.locations.create') }}" class="bg-blue-800 text-white px-5 py-2 rounded hover:bg-blue-600 transition">
        + Add New Location
    </a>
</div>


        <!-- Desktop Table -->
        <div class="hidden md:block bg-white shadow border border-blue-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm sm:text-base">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Location Name	</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Actions</th>
                       
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($locations as $location)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">{{ $location->name }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('admin.locations.edit', $location->id) }}"                                 class="bg-green-700 text-white px-3 py-1 rounded text-xs xm:text-sm hover:bg-green-600 transition-colors">

Edit</a>
                                <form action="{{ route('admin.locations.destroy', $location->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure to delete this location?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-700 text-white px-3 py-1 rounded text-xs hover:bg-red-500 transition">Delete</button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-4">No locations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bottom Back Button -->
        <div class="mt-8">
            <a href="{{ route('admin.dashboard') }}" 
               class="group relative inline-block text-blue-800 font-semibold px-4 py-2 hover:text-blue-600 focus:outline-none">
                ← Back
                <span class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600 scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
            </a>
        </div>
    </div>
</div>
@endsection
