@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold text-blue-800 mb-4">🛡️ Security Managers</h1>

    <div class="border-4 border-blue-900 rounded-2xl p-4 sm:p-6 md:p-10 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">

        <!-- Add Security Manager Button -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
            <a href="{{ route('admin.security_managers.create') }}"
               class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors text-sm sm:text-base w-full sm:w-auto text-center">
                + Add Security Manager
            </a>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-white shadow overflow-hidden border border-blue-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Employee ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Approver</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($managers as $index => $manager)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $manager->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $manager->employee_id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $manager->approverDgm->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $manager->core->email ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-right space-x-2">
                            <a href="{{ route('admin.security_managers.edit', $manager->id) }}"
                               class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-600 transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('admin.security_managers.delete', $manager->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')"
                                        class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    @if($managers->isEmpty())
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 text-sm">No Security Managers found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="block md:hidden space-y-4 mt-4">
            @foreach($managers as $index => $manager)
            <div class="bg-white border border-blue-200 rounded-lg shadow p-4">
                <p class="text-xs text-gray-500 mb-1"># {{ $index + 1 }}</p>
                <p class="text-sm font-bold text-gray-800">Name: {{ $manager->name }}</p>
                <p class="text-sm text-gray-700">Employee ID: {{ $manager->employee_id }}</p>
                <p class="text-sm text-gray-700">Approver: {{ $manager->approverDgm->name ?? '-' }}</p>
                <p class="text-sm text-gray-700">Email: {{ $manager->core->email ?? '-' }}</p>
                <div class="mt-3 flex justify-end space-x-2">
                    <a href="{{ route('admin.security_managers.edit', $manager->id) }}"
                               class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-600 transition-colors">
                        Edit
                    </a>
                    <form action="{{ route('admin.security_managers.delete', $manager->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')"
                                        class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach

            @if($managers->isEmpty())
            <p class="text-center text-gray-500 text-sm">No Security Managers found.</p>
            @endif
        </div>

        <!-- Bottom Back Button -->
        <div class="mt-8 flex justify-center sm:justify-start">
            <a href="{{ route('admin.dashboard') }}"
               class="group relative inline-block text-blue-800 font-semibold px-4 py-2 hover:text-blue-600 focus:outline-none">
                ← Back
                <span class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600 scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
            </a>
        </div>
    </div>
</div>
@endsection
