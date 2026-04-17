@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold text-blue-800 mb-4">🏢 Companies</h1>

    <div class="border-4 border-blue-900 rounded-2xl p-6 sm:p-10 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">
        
        <!-- Add Company Button -->
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('admin.companies.create') }}" 
               class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors text-sm sm:text-base">
                + Add Company
            </a>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-white shadow border border-blue-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm sm:text-base">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">BRN</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Contact</th>
                        <th class="px-6 py-3 text-right font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($companies as $index => $company)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $index + 1 }}</td>
                        <td class="px-6 py-3">{{ $company->brn }}</td>
                        <td class="px-6 py-3">{{ $company->name }}</td>
                        <td class="px-6 py-3">{{ $company->contact_person }}</td>
                        <td class="px-6 py-3 text-right space-x-2">
                            <a href="{{ route('admin.companies.edit', $company->id) }}" 
                               class="bg-green-700 text-white px-3 py-1 rounded text-xs xm:text-sm hover:bg-green-600 transition-colors">Edit</a>

                            <form action="{{ route('admin.companies.delete', $company->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" 
                                        class="bg-red-700 text-white px-3 py-1 rounded text-xs xm:text-sm hover:bg-red-600 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4 mt-4">
            @foreach($companies as $index => $company)
            <div class="bg-white shadow rounded-lg p-4 border border-gray-200">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $company->name }}</h2>
                    <span class="text-gray-500 text-sm">#{{ $index + 1 }}</span>
                </div>
                <p class="text-sm text-gray-600"><strong>BRN:</strong> {{ $company->brn }}</p>
                <p class="text-sm text-gray-600"><strong>Contact:</strong> {{ $company->contact_person }}</p>
                
                <!-- Actions -->
                <div class="flex justify-end mt-3 space-x-2">
                    <a href="{{ route('admin.companies.edit', $company->id) }}" 
                       class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-500 transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.companies.delete', $company->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" 
                                class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-500 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        @if($companies->isEmpty())
        <div class="text-center text-gray-500 mt-6 text-sm">No companies found.</div>
        @endif

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
