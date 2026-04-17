@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">
    <h1 class="text-xl sm:text-2xl font-bold text-blue-800 mb-4">🚨 Patrol Officers</h1>

    <div class="border-4 border-blue-900 rounded-2xl p-4 sm:p-8 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">

        <!-- Add Patrol Officer Button -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
            <a href="{{ route('admin.patrol_officers.create') }}" 
               class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors text-sm sm:text-base w-full sm:w-auto text-center">
                + Add Patrol Officer
            </a>
        </div>

        <!-- Table for Desktop -->
        <div class="hidden sm:block bg-white shadow border border-blue-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">SLT Employee ID</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Location</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Manager</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($officers as $index => $officer)
                    <tr>
                        <td class="px-4 py-3 text-gray-800">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $officer->name }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $officer->slt_employee_id }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $officer->location->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $officer->manager->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $officer->core->email ?? '-' }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.patrol_officers.edit', $officer->id) }}" 
                               class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-600 transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('admin.patrol_officers.delete', $officer->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" 
                                        class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">No Patrol Officers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card Layout for Mobile -->
        <div class="block sm:hidden">
            @forelse($officers as $index => $officer)
            <div class="bg-white rounded-lg shadow-md p-4 mb-4 border border-gray-200">
                <div class="text-blue-800 font-semibold mb-2">#{{ $index + 1 }} - {{ $officer->name }}</div>
                <p><span class="font-semibold">SLT Employee ID:</span> {{ $officer->slt_employee_id }}</p>
                <p><span class="font-semibold">Manager:</span> {{ $officer->manager->name ?? '-' }}</p>
                <p><span class="font-semibold">Email:</span> {{ $officer->core->email ?? '-' }}</p>
                
                <!-- Action Buttons -->
                <div class="mt-3 flex flex-wrap gap-2">
                    <a href="{{ route('admin.patrol_officers.edit', $officer->id) }}" 
                       class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-500 transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.patrol_officers.delete', $officer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" 
                                class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-500 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500">No Patrol Officers found.</div>
            @endforelse
        </div>

        <!-- Bottom Back Button -->
        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" 
               class="group relative inline-block text-blue-800 font-semibold px-4 py-2 hover:text-blue-600 focus:outline-none">
                ← Back
                <span class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600 scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
            </a>
        </div>
    </div>
</div>
@endsection
