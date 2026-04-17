@extends('layouts.app')

@section('content')
<style>
    .select2-results__option[aria-disabled=true] {
        color: #999 !important;
        background-color: #eee !important;
        cursor: not-allowed;
    }
    .card-number-header {
        background-color: #f0f7ff;
        font-weight: bold;
        padding: 8px;
        margin-top: 20px;
        border-bottom: 2px solid #3b82f6;
    }
    .timecard-table {
        margin-bottom: 30px;
    }
</style>

<div class="max-w-7xl mx-auto px-1 py-6">
     <div class="border-4 border-blue-900 rounded-2xl p-6 bg-blue-50 shadow-lg">
    <h2 class="text-2xl font-bold text-blue-700 mb-4">Submit Timecard</h2>

    @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('patrol.timecards.store') }}" method="POST" class="space-y-4 bg-white p-4 rounded shadow">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="date" class="block text-sm font-semibold mb-1">📅 Select Date:</label>
                <input type="date" id="date" name="date"
                    class="w-full border rounded px-3 py-2"
                    value="{{ request('filter_date', \Carbon\Carbon::today()->toDateString()) }}"
                    required onchange="filterGuardsByDate()">
            </div>
        </div>

        <div id="timecard-rows" class="space-y-4">
            <!-- Template for cloning -->
            <div class="grid gap-2 sm:grid-cols-6 timecard-row">
                <select class="guard-select w-full text-sm" name="security_officer_id[]" style="width: 100%">
                    <option value="">-- Select Officer --</option>
                </select>
            
                <select name="shift_type_id[]" required class="border rounded px-2 py-2 w-full">
                    <option value="">-- Select Shift --</option>
                    @foreach($shifts as $shift)
                    <option value="{{ $shift->id }}">{{ $shift->name }} ({{ $shift->duration }} hrs)</option>
                    @endforeach
                </select>

                <input type="time" name="started_at[]" class="border rounded px-2 py-2 w-full" required>

                <input type="date" name="ended_date[]" class="border rounded px-2 py-2 w-full"
                    value="{{ \Carbon\Carbon::today()->toDateString() }}">

                <input type="time" name="ended_time[]" class="border rounded px-2 py-2 w-full" required>

                <div class="flex items-center gap-2 action-buttons">
                    <input type="text" name="remarks[]" class="border rounded px-2 py-2 w-full" placeholder="Remarks">
                    <button type="button" class="action-btn text-green-600 text-xl h-8 w-8 flex items-center justify-center" onclick="addRow()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>

        <button type="submit"
            class="w-full sm:w-auto bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Submit Timecard
        </button>
    </form>

    <hr class="my-8">

    <form method="GET" class="mb-6 bg-white p-4 rounded shadow space-y-3">
        <label for="filter_date" class="block text-sm font-semibold">📅 Filter Timecards by Date:</label>
        <div class="flex flex-col sm:flex-row gap-2">
            <input type="date" name="filter_date" id="filter_date"
                value="{{ request('filter_date', \Carbon\Carbon::today()->toDateString()) }}"
                class="border rounded px-3 py-2 w-full sm:w-auto">
            <button type="submit"
class="bg-gray-700 text-white px-3 py-1 rounded text-xs hover:bg-gray-500 transition-all duration-200 hover:shadow-md">                Filter
            </button>

            @if(request('filter_date'))
            <a href="{{ route('patrol.timecards.pdf', request('filter_date')) }}"
                class="text-blue-700 underline px-3 py-2 w-full sm:w-auto text-center"
                target="_blank">
                📄 Download PDF
            </a>
            @endif
        </div>
    </form>

    <h3 class="text-xl font-semibold mb-4">Submitted Timecards</h3>

    <!-- Group timecards by card number -->
    @php
        $groupedTimecards = $timecards->groupBy('securityOfficer.card_number');
    @endphp

    @foreach($groupedTimecards as $cardNumber => $cardTimecards)
        <div class="card-number-header">
            Card Number: {{ $cardNumber }} - {{ $cardTimecards->first()->securityOfficer->name ?? 'Unknown Officer' }}
        </div>
        
        <div class="overflow-x-auto timecard-table">
            <table class="min-w-full text-sm text-left border border-gray-300">
                <thead class="bg-blue-100 hidden sm:table-header-group">
                    <tr>
                        <th class="px-3 py-2">No</th>
                        <th class="px-3 py-2">Officer</th>
                        <th class="px-3 py-2">Shift</th>
                        <th class="px-3 py-2">Start</th>
                        <th class="px-3 py-2">End Date</th>
                        <th class="px-3 py-2">End Time</th>
                        <th class="px-3 py-2">Overtime (hrs)</th>
                        <th class="px-3 py-2">Pay?</th>
                        <th class="px-3 py-2">Remarks</th>
                        <th class="px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cardTimecards as $tc)
                        @php
                            $workedHours = $tc->worked_hours ?? 0;
                            $highlightRed = $workedHours >= 36 
                                ? 'bg-red-100 border-l-4 border-red-500'
                                : ($workedHours > 24 
                                    ? 'bg-red-50 border-l-4 border-red-300'
                                    : 'bg-white');
                        @endphp

                        <tr data-id="{{ $tc->id }}" 
                            class="sm:table-row block  border-b sm:border-none mb-4 sm:mb-0 shadow-sm rounded overflow-hidden {{ $highlightRed }}">

                            <td class="sm:px-3 py-2 sm:table-cell block px-4 pt-2 font-bold sm:font-normal">{{ $loop->iteration }}</td>
                            <td class="sm:px-3 py-2 sm:table-cell block px-4">{{ $tc->securityOfficer->name ?? '-' }}</td>
                            <td class="sm:px-3 py-2 sm:table-cell block px-4">
                                <select class="edit-field border rounded px-1 py-1 w-full sm:w-auto" name="shift_type_id">
                                    @foreach($shifts as $shift)
                                    <option value="{{ $shift->id }}" {{ $shift->id == $tc->shift_type_id ? 'selected' : '' }}>{{ $shift->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="sm:px-3 py-2 sm:table-cell block px-4">
                                <input type="time" class="edit-field border rounded px-1 py-1 w-full sm:w-auto" name="started_at" value="{{ \Carbon\Carbon::parse($tc->started_at)->format('H:i') }}">
                            </td>
                            <td class="sm:px-3 py-2 sm:table-cell block px-4">
                                <input type="date" class="edit-field border rounded px-1 py-1 w-full sm:w-auto" name="ended_date" value="{{ \Carbon\Carbon::parse($tc->ended_at)->toDateString() }}">
                            </td>
                            <td class="sm:px-3 py-2 sm:table-cell block px-4">
                                <input type="time" class="edit-field border rounded px-1 py-1 w-full sm:w-auto" name="ended_time" value="{{ \Carbon\Carbon::parse($tc->ended_at)->format('H:i') }}">
                            </td>
                            <td class="sm:px-3 py-2 sm:table-cell block px-4">
                                <input type="number" step="0.1" name="overtime_hours" class="edit-field border rounded px-1 py-1 w-full sm:w-20" value="{{ $tc->overtime_hours }}">
                            </td>
                            <td class="sm:px-3 py-2 sm:table-cell block px-4">
                                <input type="checkbox" name="is_pay" class="edit-field" {{ $tc->is_pay ? 'checked' : '' }}>
                            </td>
                            <td class="sm:px-3 py-2 sm:table-cell block px-4">
                                <input type="text" class="edit-field border rounded px-1 py-1 w-full sm:w-auto" name="remarks" value="{{ $tc->remarks }}">
                            </td>
                            <td class="sm:px-3 py-2 sm:table-cell block px-4 flex gap-2">
                                <button class="bg-green-500 text-white px-3 py-1 rounded save-btn w-full sm:w-auto">
                                    <i class="fas fa-save"></i>
                                </button>
                                <button class="bg-red-500 text-white px-3 py-1 rounded delete-btn w-full sm:w-auto">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    @if($groupedTimecards->isEmpty())
        <div class="text-center py-3 text-gray-500">No timecards submitted.</div>
    @endif
</div>
</div>
@endsection

@push('scripts')
<script>
let blockedGuards = [];

function filterGuardsByDate() {
    const date = document.getElementById('date').value;
    if (!date) return;

    fetch(`/patrol/timecards/check/${date}?_=${Date.now()}`)
        .then(res => res.json())
        .then(data => {
            blockedGuards = data.map(id => String(id));
            applyAllFilters();
        });
}

function getSelectedOfficerIds() {
    const selects = document.querySelectorAll('select[name="security_officer_id[]"]');
    return Array.from(selects).map(select => select.value).filter(Boolean);
}

function addRow() {
    const container = document.getElementById('timecard-rows');
    const firstRow = container.querySelector('.timecard-row');

    // Clone base row
    const newRow = firstRow.cloneNode(true);

    // Clean up select2: remove cloned Select2 DOM
    const oldContainer = newRow.querySelector('.select2-container');
    if (oldContainer) oldContainer.remove();

    // Create a fresh select element
    const newSelect = document.createElement('select');
    newSelect.name = 'security_officer_id[]';
    newSelect.className = 'guard-select w-full text-sm';
    newSelect.innerHTML = `<option value="">-- Select Officer --</option>`;
    
    const oldSelect = newRow.querySelector('select[name="security_officer_id[]"]');
    oldSelect.parentNode.replaceChild(newSelect, oldSelect);

    // Reset all other inputs
    newRow.querySelectorAll('input').forEach(input => {
        if (input.name === 'ended_date[]') {
            input.value = document.getElementById('date').value;
        } else {
            input.value = '';
        }
    });

    newRow.querySelectorAll('select').forEach(select => {
        if (select.name !== 'security_officer_id[]') {
            select.selectedIndex = 0;
        }
    });

    container.appendChild(newRow);

    initGuardSelect();
    applyAllFilters();
    updateAllRowButtons();
}

function applyAllFilters() {
    const allRows = document.querySelectorAll('.timecard-row');
    const selectedValues = [];

    allRows.forEach(row => {
        const select = row.querySelector('select[name="security_officer_id[]"]');
        if (select.value) {
            selectedValues.push(select.value);
        }
    });

    allRows.forEach(currentRow => {
        const select = currentRow.querySelector('select[name="security_officer_id[]"]');
        const currentVal = select.value;

        $(select).find('option').each(function () {
            const optionVal = this.value;

            if (!optionVal) return; // Skip placeholder

            // Disable if selected elsewhere (not this row)
            const isUsed = selectedValues.includes(optionVal) && optionVal !== currentVal;
            this.disabled = isUsed;
        });

        // Force Select2 to redraw
        $(select).select2('destroy').select2({
            placeholder: 'Search officer by name or NIC',
            theme: 'classic',
            width: '100%',
            ajax: {
                url: "{{ route('patrol.guards.search') }}",
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term }),
                processResults: data => ({
                    results: data.map(guard => ({
                        id: guard.id,
                        text: `${guard.name} (${guard.nic})`
                    }))
                }),
                cache: true
            },
            minimumInputLength: 1
        });
    });
}

function removeRow(button) {
    const row = button.closest('.timecard-row');
    row.remove();
    applyAllFilters();
}

function updateAllRowButtons() {
    const rows = document.querySelectorAll('.timecard-row');

    rows.forEach((row, index) => {
        const actionContainer = row.querySelector('.action-buttons');
        actionContainer.innerHTML = `
            <input type="text" name="remarks[]" class="border rounded px-2 py-2 w-full" placeholder="Remarks">
        `;

        if (index === 0) {
            // Only + button
            actionContainer.innerHTML += `
                <button type="button" class="text-green-600 text-xl h-8 w-8 flex items-center justify-center" onclick="addRow()">
                    <i class="fas fa-plus"></i>
                </button>
            `;
        } else {
            // Both − and +
            actionContainer.innerHTML += `
                <button type="button" class="text-red-600 text-xl h-8 w-8 flex items-center justify-center" onclick="removeRow(this)">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="text-green-600 text-xl h-8 w-8 flex items-center justify-center" onclick="addRow()">
                    <i class="fas fa-plus"></i>
                </button>
            `;
        }
    });
}

function initGuardSelect() {
    document.querySelectorAll('select.guard-select').forEach(el => {
        if (!$(el).hasClass("select2-hidden-accessible")) {
            $(el).select2({
                placeholder: 'Search officer by name or NIC',
                theme: 'classic',
                width: '100%',
                ajax: {
                    url: "{{ route('patrol.guards.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({ q: params.term }),
                    processResults: data => ({
                        results: data.map(guard => ({
                            id: guard.id,
                            text: `${guard.name} (${guard.nic})`
                        }))
                    }),
                    cache: true
                },
                minimumInputLength: 1
            });
        }
    });
}

window.addEventListener('load', () => {
    filterGuardsByDate();
    initGuardSelect();
    updateAllRowButtons();

    document.querySelectorAll('.save-btn').forEach(button => {
        button.addEventListener('click', async function () {
            const row = this.closest('tr');
            const id = row.dataset.id;

            const shift_type_id = row.querySelector('[name="shift_type_id"]').value;
            const started_at = row.querySelector('[name="started_at"]').value;
            const ended_date = row.querySelector('[name="ended_date"]').value;
            const ended_time = row.querySelector('[name="ended_time"]').value;
            const remarks = row.querySelector('[name="remarks"]').value;
            const overtime_hours = row.querySelector('[name="overtime_hours"]').value;
            const is_pay = row.querySelector('[name="is_pay"]').checked;

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch(`/patrol/timecards/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    shift_type_id,
                    started_at,
                    ended_date,
                    ended_time,
                    remarks,
                    overtime_hours,
                    is_pay
                })
            });

            if (response.ok) {
                alert(' Updated successfully.');
                location.reload();
            } else {
                alert(' Update failed.');
            }
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', async function () {
            if (!confirm('Are you sure you want to delete this timecard?')) return;
            const row = this.closest('tr');
            const id = row.dataset.id;

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch(`/patrol/timecards/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                alert(' Deleted successfully.');
                row.remove();
            } else {
                alert(' Deletion failed.');
            }
        });
    });
});
</script>
@endpush