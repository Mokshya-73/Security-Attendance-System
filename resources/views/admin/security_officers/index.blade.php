@extends('layouts.app') 

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-xl sm:text-2xl font-bold text-blue-800 mb-4">🧍 Security Officers</h1>

    <div class="border-4 border-blue-900 rounded-2xl p-4 sm:p-8 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">

        <!-- Filter Section -->
        <form method="GET" action="{{ route('admin.security_officers.index') }}" class="mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label for="patrol_id" class="block text-sm font-medium text-black">Filter by Patrol Officer</label>
                <select name="patrol_id" id="patrol_id" class="w-52 border border-gray-300 rounded px-3 py-2 text-sm">
                    <option value="">All Patrols</option>
                    @foreach($patrols as $patrol)
                        <option value="{{ $patrol->id }}" {{ request('patrol_id') == $patrol->id ? 'selected' : '' }}>
                            {{ $patrol->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="location_id" class="block text-sm font-medium text-black">Filter by Location</label>
                <select name="location_id" id="location_id" class="w-52 border border-gray-300 rounded px-3 py-2 text-sm">
                    <option value="">All Locations</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-gray-700 text-white px-3 py-1 rounded text-xs hover:bg-gray-500 transition-all duration-200 hover:shadow-md">
                Apply Filter
            </button>
            <a href="{{ route('admin.security_officers.index') }}" class="bg-red-700 text-white px-3 py-1 rounded text-xs hover:bg-red-500 transition-all duration-200 hover:shadow-md">
                Reset
            </a>
        </form>


        @foreach($officers as $index => $officer)
    <!-- Card content here -->

    @if(!$loop->last)
        <hr class="my-6 border-t-2 border-blue-800 opacity-70">
    @endif
@endforeach


        <!-- Add Security Officer Button -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
            <a href="{{ route('admin.security_officers.create') }}" 
               class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors text-sm sm:text-base w-full sm:w-auto text-center">
                + Add Security Officer
            </a>
        </div>

        <!-- Grid Card View (Desktop & Tablet) -->
        <div class="hidden sm:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach($officers as $index => $officer)
                @php $nicPhotos = json_decode($officer->nic_photo_path, true) ?? []; @endphp

                <div class="group bg-white rounded-2xl shadow-lg p-6 hover:bg-cyan-50 border-2 border-blue-400 hover:border-blue-700 transform hover:scale-105 transition-all drop-shadow-md hover:drop-shadow-[0_4px_10px_rgba(59,130,246,0.8)]">
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <h2 class="text-lg font-semibold text-blue-800">👮 Officer {{ $index + 1 }}</h2>
                        <div class="space-x-2">
                            <a href="{{ route('admin.security_officers.edit', $officer->id) }}" 
                               class="bg-green-700 text-white px-3 py-1.5 rounded-md text-xs hover:bg-green-500 transition-all duration-200 hover:shadow-md">
                                Edit
                            </a>
                            <form action="{{ route('admin.security_officers.delete', $officer->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" 
                                        class="bg-red-700 text-white px-3 py-1.5 rounded-md text-xs hover:bg-red-500 transition-all duration-200 hover:shadow-md">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <ul class="list-disc list-inside text-gray-700 text-sm space-y-1 font-[500] relative z-10">
                        <li><span class="text-gray-600">Title:</span> {{ $officer->title?->title ? $officer->title->title . '. ' : '' }}{{ $officer->name }}</li>
                        <li><span class="text-gray-600">NIC:</span> {{ $officer->nic }}</li>
                        <li><span class="text-gray-600">Service No:</span> A/{{ $officer->service_number }}</li>
                        <li><span class="text-gray-600">Location:</span> {{ $officer->location->name ?? '-' }}</li>
                        <li><span class="text-gray-600">Phone:</span> {{ $officer->telephone }}</li>
                        <li><span class="text-gray-600">Company:</span> {{ $officer->company->name ?? '-' }}</li>
                        <li><span class="text-gray-600">Patrol:</span> {{ $officer->patrol->name ?? '-' }}</li>
                    </ul>

                    <div class="mt-4 flex gap-3 relative z-10">
                        @if(!empty($nicPhotos['front']))
                            <img src="{{ asset('storage/' . $nicPhotos['front']) }}" alt="NIC Front" class="w-20 h-auto rounded-md border border-gray-300 shadow-sm hover:scale-105 transition-transform duration-300">
                        @endif
                        @if(!empty($nicPhotos['back']))
                            <img src="{{ asset('storage/' . $nicPhotos['back']) }}" alt="NIC Back" class="w-20 h-auto rounded-md border border-gray-300 shadow-sm hover:scale-105 transition-transform duration-300">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Mobile Card View -->
        <div class="block sm:hidden space-y-4 mt-4">
            @forelse($officers as $index => $officer)
                @php $nicPhotos = json_decode($officer->nic_photo_path, true) ?? []; @endphp
                <div class="bg-white rounded-lg shadow-lg p-4 transition-all duration-300 ease-in-out border-2 border-blue-800 hover:border-blue-900 hover:ring-2 hover:ring-blue-400">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-base font-semibold text-blue-800">👮 Officer {{ $index + 1 }} - {{ $officer->name }}</h2>
                    </div>
                    <p class="text-sm text-gray-700"><span class="font-semibold">NIC:</span> {{ $officer->nic }}</p>
                    <p class="text-sm text-gray-700"><span class="font-semibold">Phone:</span> {{ $officer->telephone }}</p>
                    <p class="text-sm text-gray-700"><span class="font-semibold">Company:</span> {{ $officer->company->name ?? '-' }}</p>
                    <p class="text-sm text-gray-700"><span class="font-semibold">Patrol:</span> {{ $officer->patrol->name ?? '-' }}</p>
                    <p class="text-sm text-gray-700"><span class="font-semibold">Location:</span> {{ $officer->location->name ?? '-' }}</p>

                    @if(!empty($nicPhotos['front']) || !empty($nicPhotos['back']))
                        <div class="mt-3 flex gap-3">
                            @if(!empty($nicPhotos['front']))
                                <img src="{{ asset('storage/' . $nicPhotos['front']) }}" alt="NIC Front" class="w-20 h-auto rounded border">
                            @endif
                            @if(!empty($nicPhotos['back']))
                                <img src="{{ asset('storage/' . $nicPhotos['back']) }}" alt="NIC Back" class="w-20 h-auto rounded border">
                            @endif
                        </div>
                    @endif

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('admin.security_officers.edit', $officer->id) }}" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-500 transition-all duration-200 hover:shadow-md">
                            Edit
                        </a>
                        <form action="{{ route('admin.security_officers.delete', $officer->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-500 transition-all duration-200 hover:shadow-md">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 text-sm">No Security Officers found.</div>
            @endforelse
        </div>



        <div class="flex justify-between items-center mt-4">
  <!-- Back button on left -->
 <a href="{{ route('admin.dashboard') }}" 
               class="group relative inline-block text-blue-800 font-semibold px-4 py-2 hover:text-blue-600 focus:outline-none">
   ← Back
                <span class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600 scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
</a>
            
        </div>
    </form>
</div>


    </div>
</div>
@endsection
