@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-8">

    <h2 class="text-2xl font-bold text-blue-800 mb-4 text-center">Security Manager Dashboard</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-6 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- 🔍 Filters --}}
    <form method="GET" action="{{ route('manager.dashboard') }}" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-4 rounded shadow">
        <div>
            <label for="officer_id" class="block text-sm font-semibold text-gray-700 mb-1">Filter by Patrol Officer</label>
            <select name="officer_id" id="officer_id" class="w-full border rounded px-3 py-2">
                <option value="">-- All Officers --</option>
                @foreach($officers as $officer)
                    <option value="{{ $officer->user_core_data_id }}" {{ request('officer_id') == $officer->user_core_data_id ? 'selected' : '' }}>
                        {{ $officer->core->employee_id ?? 'N/A' }} - {{ $officer->name ?? 'N/A' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="date" class="block text-sm font-semibold text-gray-700 mb-1">Filter by Date</label>
            <input type="date" name="date" id="date" value="{{ request('date') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-600 transition w-full">Filter</button>
            <a href="{{ route('manager.dashboard') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition w-full text-center">Clear</a>
        </div>
    </form>

    {{-- 📋 Table --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">

        {{-- Desktop View --}}
        <table class="min-w-full hidden md:table text-sm">
            <thead class="bg-blue-200  text-left">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Security Officer</th>
                    <th class="px-4 py-3">Patrol Officer</th>
                    <th class="px-4 py-3">Shift</th>
                    <th class="px-4 py-3">Start Time</th>
                    <th class="px-4 py-3">End Time</th>
                    <th class="px-4 py-3">OT</th>
                    <th class="px-4 py-3">Pay</th>
                    <th class="px-4 py-3">Remarks</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($timecards as $tc)
                <tr>
                    <form action="{{ route('security_manager.timecards.update', $tc->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $tc->securityOfficer->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @php
                                $officer = \App\Models\PatrolOfficer::where('user_core_data_id', $tc->patrol_officer_id)->first();
                            @endphp
                            {{ $officer ? $officer->name . ' (' . $officer->slt_employee_id . ')' : 'N/A' }}
                        </td>

                        <td class="px-4 py-2">
                            <select name="shift" class="form-select w-32 md:w-36">


                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id }}" {{ $shift->id == $tc->shift_type_id ? 'selected' : '' }}>
                                        {{ $shift->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td class="px-4 py-2">
                            <input type="time" name="started_at" value="{{ \Carbon\Carbon::parse($tc->started_at)->format('H:i') }}" class="border rounded px-2 py-1 w-full" required>
                        </td>

                        <td class="px-4 py-2">
                            <div class="flex gap-1">
                                <input type="date" name="ended_date" value="{{ \Carbon\Carbon::parse($tc->ended_at)->format('Y-m-d') }}" class="border rounded px-2 py-1 w-full" required>
                                <input type="time" name="ended_time" value="{{ \Carbon\Carbon::parse($tc->ended_at)->format('H:i') }}" class="border rounded px-2 py-1 w-full" required>
                            </div>
                        </td>

                        <td class="px-4 py-2 text-center">
                            {{ $tc->is_overtime ? '+' . number_format($tc->overtime_hours, 1) . ' hrs' : '-' }}
                        </td>

                        <td class="px-4 py-2 text-center">
                            @if($tc->is_pay)
                                <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Yes</span>
                            @else
                                <span class="inline-block px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">No</span>
                            @endif
                        </td>

                        <td class="px-4 py-2">
                            <input type="text" name="remarks" value="{{ $tc->remarks }}" class="border rounded px-2 py-1 w-full">
                        </td>

                        <td class="px-4 py-2 text-center">
                           <button class="text-blue-600 hover:text-blue-800 text-base" title="Save">
    <i class="fas fa-save text-lg"></i>
</button>


                    </form>
                            <form action="{{ route('security_manager.timecards.destroy', $tc->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this timecard?')">
                                @csrf
                                @method('DELETE')
                               <button class="text-red-600 hover:text-red-800 text-base" title="Delete">
    <i class="fas fa-trash-alt text-lg"></i>
</button>


                            </form>
                        </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center px-4 py-6 text-gray-500">No timecards found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Mobile View --}}
        <div class="md:hidden divide-y divide-gray-200">
            @forelse($timecards as $tc)
            <div class="p-4 bg-white rounded-xl shadow m-2 border border-gray-100 space-y-2">
                <form action="{{ route('security_manager.timecards.update', $tc->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <p><strong>Officer:</strong> {{ $tc->securityOfficer->name ?? '-' }}</p>
                    <p><strong>Patrol:</strong>
                        @php
                            $officer = \App\Models\PatrolOfficer::where('user_core_data_id', $tc->patrol_officer_id)->first();
                        @endphp
                        {{ $officer ? $officer->name . ' (' . $officer->slt_employee_id . ')' : 'N/A' }}
                    </p>
                    <p>
                        <strong>Shift:</strong>
                        <select name="shift_type_id" class="border rounded px-2 py-1 w-full">
                            @foreach($shifts as $shift)
                                <option value="{{ $shift->id }}" {{ $shift->id == $tc->shift_type_id ? 'selected' : '' }}>{{ $shift->name }}</option>
                            @endforeach
                        </select>
                    </p>
                    <p><strong>Start:</strong> <input type="time" name="started_at" value="{{ \Carbon\Carbon::parse($tc->started_at)->format('H:i') }}" class="border rounded px-2 py-1 w-full" required></p>
                    <p>
                        <strong>End:</strong>
                        <div class="flex gap-1">
                            <input type="date" name="ended_date" value="{{ \Carbon\Carbon::parse($tc->ended_at)->format('Y-m-d') }}" class="border rounded px-2 py-1 w-full" required>
                            <input type="time" name="ended_time" value="{{ \Carbon\Carbon::parse($tc->ended_at)->format('H:i') }}" class="border rounded px-2 py-1 w-full" required>
                        </div>
                    </p>
                    <p><strong>OT:</strong> {{ $tc->is_overtime ? '+' . number_format($tc->overtime_hours, 1) . ' hrs' : '-' }}</p>
                    <p><strong>Pay:</strong>
                        @if($tc->is_pay)
                            <span class="text-green-600 font-medium">Yes</span>
                        @else
                            <span class="text-red-600 font-medium">No</span>
                        @endif
                    </p>
                    <p><strong>Remarks:</strong> <input type="text" name="remarks" value="{{ $tc->remarks }}" class="border rounded px-2 py-1 w-full"></p>
                    <div class="flex justify-between mt-2">
                       <button class="text-blue-600 hover:text-blue-800 text-base" title="Save">
    <i class="fas fa-save text-lg"></i>
</button>


                </form>
                        <form action="{{ route('security_manager.timecards.destroy', $tc->id) }}" method="POST" onsubmit="return confirm('Delete this timecard?')">
                            @csrf
                            @method('DELETE')
                           <button class="text-red-600 hover:text-red-800 text-base " title="Delete">
    <i class="fas fa-trash-alt text-lg"></i>
</button>


                        </form>
                    </div>
            </div>
            @empty
            <div class="p-4 text-center text-gray-500">No timecards found.</div>
            @endforelse
        </div>

    </div>
</div>
@endsection
