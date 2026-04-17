@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    

     <!-- Blue Border Wrapper -->
        
            <!-- Welcome Message and Current Time -->
            <div class="mb-8">
                 <h2 class="text-2xl font-bold text-blue-800 mb-6 text-center">Company User Dashboard</h2>
                 
                <p class="text-lg text-gray-600">Today is {{ now()->format('l, F j, Y') }}</p>
            </div>
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-4 rounded-xl shadow border border-gray-200">
            <p class="text-sm text-gray-500">Total Timecards</p>
            <p class="text-2xl font-semibold text-blue-700">{{ $total }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow border border-gray-200">
            <p class="text-sm text-gray-500">Today's Entries</p>
            <p class="text-2xl font-semibold text-green-600">{{ $today }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow border border-gray-200">
            <p class="text-sm text-gray-500">This Month</p>
            <p class="text-2xl font-semibold text-indigo-600">{{ $monthly }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow border border-gray-200">
            <p class="text-sm text-gray-500">Total Overtime (hrs)</p>
            <p class="text-2xl font-semibold text-red-600">{{ $overtime }}</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Pie Chart --}}
        <div class="bg-white p-4 rounded-xl shadow border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Timecard Summary</h3>
            <canvas id="pieChart"></canvas>
        </div>

        {{-- Line Chart --}}
        <div class="bg-white p-4 rounded-xl shadow border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Overtime Trend</h3>
            <canvas id="lineChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const pieChart = new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Total Timecards', "Today's Entries", 'This Month'],
            datasets: [{
                label: 'Entries',
                data: [{{ $total }}, {{ $today }}, {{ $monthly }}],
                backgroundColor: ['#3b82f6', '#10b981', '#6366f1'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    const lineChart = new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Total Overtime (hrs)',
                data: [{{ $overtime * 0.2 }}, {{ $overtime * 0.5 }}, {{ $overtime * 0.75 }}, {{ $overtime }}],
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointStyle: 'circle'
            },
            {
                label: 'Limit (1200 hrs)',
                data: [1200, 1200, 1200, 1200],
                borderColor: 'red',
                borderWidth: 2,
                borderDash: [10, 5],
                pointRadius: 0,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 1400
                }
            }
        }
    });
</script>
@endpush
<style>
    #pieChart, #lineChart {
        width: 100% !important;
        max-width: 100%;
        height: 300px !important;
        max-height: 300px;
        display: block;
    }
</style>

 
