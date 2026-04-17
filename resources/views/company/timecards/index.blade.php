@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6">

    <h2 class="text-2xl font-bold text-blue-800 mb-4 text-center">Timecard Records</h2>

    

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('company.timecards.index') }}"
          class="mb-6 bg-white p-6 rounded-xl shadow border border-gray-200 space-y-4">

        {{-- Filter Type Dropdown --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Filter By</label>
                <select id="filter_type" class="w-full border rounded-lg p-2">
                    <option value="none">-- Select --</option>
                    <option value="date" {{ request('date') ? 'selected' : '' }}>Specific Date</option>
                    <option value="range" {{ request('start_date') && request('end_date') ? 'selected' : '' }}>Date Range</option>
                    <option value="month" {{ request('month') ? 'selected' : '' }}>Month</option>
                </select>
            </div>

            {{-- Location --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"> Location</label>
                <select name="location_id" class="w-full border rounded-lg p-2">
                    <option value="">All Locations</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Specific Date --}}
        <div id="filter_date" class="hidden">
            <label class="block text-sm font-semibold text-gray-700 mb-1 mt-4"> Specific Date</label>
            <input type="date" name="date" value="{{ request('date') }}" class="w-full border rounded-lg p-2">
        </div>

        {{-- Date Range --}}
        <div id="filter_range" class="grid grid-cols-1 sm:grid-cols-2 gap-4 hidden">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1 mt-4"> From Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border rounded-lg p-2">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1 mt-4">To Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border rounded-lg p-2">
            </div>
        </div>

        {{-- Month --}}
        <div id="filter_month" class="hidden">
            <label class="block text-sm font-semibold text-gray-700 mb-1 mt-4"> Month</label>
            <input type="month" name="month" value="{{ request('month') }}" class="w-full border rounded-lg p-2">
        </div>

        {{-- Buttons --}}
        <div class="flex flex-wrap gap-4 mt-6">
            <button type="submit"
                    class="px-5 py-2 bg-blue-800 text-white font-medium rounded-lg hover:bg-blue-600 transition">
                 Apply Filters
            </button>

            <a href="{{ route('company.timecards.index') }}"
               class="px-5 py-2 bg-gray-300 text-gray-800 font-medium rounded-lg hover:bg-gray-400 transition">
                 Reset
            </a>
        </div>
    </form>

    
 {{-- Responsive Table --}}
<div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">

    {{-- Desktop Table --}}
    <table class="min-w-full hidden md:table text-sm">
        <thead>
            <tr class="bg-blue-200  text-left">
                <th class="p-2">NIC</th>
                <th class="p-2">Name</th>
                <th class="p-2">Patrol Leader</th>
                <th class="p-2">Location</th>
                <th class="p-2">Started At</th>
                <th class="p-2">Ended At</th>
                <th class="p-2">Shift</th>
                <th class="p-2">Worked Hours</th>
                <th class="p-2">Overtime</th>
                <th class="p-2">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($timecards as $card)
            <tr class="hover:bg-gray-50 border-t">
                <td class="p-2">{{ $card->securityOfficer->nic ?? 'N/A' }}</td>
                <td class="p-2">{{ $card->securityOfficer->name ?? 'N/A' }}</td>
                <td class="p-2">{{ $card->securityOfficer->patrol->name ?? 'N/A' }}</td>
                <td class="p-2">{{ $card->securityOfficer->patrol->location->name ?? 'N/A' }}</td>
                <td class="p-2">{{ \Carbon\Carbon::parse($card->started_at)->format('Y-m-d H:i') }}</td>
                <td class="p-2">{{ \Carbon\Carbon::parse($card->ended_at)->format('Y-m-d H:i') }}</td>
                <td class="p-2">{{ $card->shiftType->name ?? 'N/A' }}</td>
                <td class="p-2">{{ $card->worked_hours }}</td>
                <td class="p-2">{{ $card->overtime_hours }}</td>
                <td class="p-2">{{ $card->remarks ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="p-4 text-center text-gray-500">No records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Mobile View --}}
    <div class="md:hidden divide-y divide-gray-200">
        @forelse($timecards as $card)
        <div class="p-4 bg-white rounded-xl shadow mb-4 border border-gray-100">
            <p><strong>NIC:</strong> {{ $card->securityOfficer->nic ?? 'N/A' }}</p>
            <p><strong>Name:</strong> {{ $card->securityOfficer->name ?? 'N/A' }}</p>
            <p><strong>Patrol Leader:</strong> {{ $card->securityOfficer->patrol->name ?? 'N/A' }}</p>
            <p><strong>Location:</strong> {{ $card->securityOfficer->patrol->location->name ?? 'N/A' }}</p>
            <p><strong>Started At:</strong> {{ \Carbon\Carbon::parse($card->started_at)->format('Y-m-d H:i') }}</p>
            <p><strong>Ended At:</strong> {{ \Carbon\Carbon::parse($card->ended_at)->format('Y-m-d H:i') }}</p>
            <p><strong>Shift:</strong> {{ $card->shiftType->name ?? 'N/A' }}</p>
            <p><strong>Worked Hours:</strong> {{ $card->worked_hours }}</p>
            <p><strong>Overtime:</strong> {{ $card->overtime_hours }}</p>
            <p><strong>Remarks:</strong> {{ $card->remarks ?? '-' }}</p>
        </div>
        @empty
        <div class="p-4 text-center text-gray-500">No records found.</div>
        @endforelse
    </div>
</div>


    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('filter_type');
        const filterDate = document.getElementById('filter_date');
        const filterRange = document.getElementById('filter_range');
        const filterMonth = document.getElementById('filter_month');

        function updateVisibility() {
            const type = typeSelect.value;
            filterDate.classList.add('hidden');
            filterRange.classList.add('hidden');
            filterMonth.classList.add('hidden');

            if (type === 'date') {
                filterDate.classList.remove('hidden');
            } else if (type === 'range') {
                filterRange.classList.remove('hidden');
            } else if (type === 'month') {
                filterMonth.classList.remove('hidden');
            }
        }

        typeSelect.addEventListener('change', updateVisibility);

        // On load
        updateVisibility();
    });
</script>
@endpush
