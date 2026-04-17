@extends('layouts.app')

@section('content')
<div class="relative py-4 px-4 sm:px-6 overflow-hidden">

    <!-- Content Wrapper -->
    <div class="relative max-w-7xl mx-auto">
        <!-- Header Section - Made more compact -->
        <div class="mb-4">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-700 text-center">
                Patrol Officer Dashboard
            </h1>
        </div>

        <!-- Blue Border Wrapper - Reduced padding -->
        <div class="border-3 border-blue-900 rounded-xl p-4 bg-white bg-opacity-90 shadow-md">
            <!-- Last updated - Made smaller -->
            <div class="flex justify-end mb-4">
                <div class="bg-white px-3 py-1 rounded-full border border-blue-600 text-xs">
                    Last updated: {{ now()->format('M d, Y h:i A') }}
                </div>
            </div>
            
            <!-- Dashboard Card - Reduced padding -->
            <div class="bg-white shadow rounded-xl border border-blue-100 p-4 mb-4">
                <!-- Heading - Made more compact -->
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 5h12M9 3v2m6 4h6M9 21H3a2 2 0 01-2-2V5a2 2 0 012-2h6a2 2 0 012 2v16z"/>
                    </svg>
                    <h2 class="text-lg font-semibold text-blue-800">Quick Actions</h2>
                </div>

                <!-- Grid Cards - Tighter spacing -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Timecards Card - More compact -->
                    <a href="{{ route('patrol.timecards.index') }}"
                       class="rounded-lg border-2 border-blue-300 bg-white hover:border-blue-600 shadow-sm hover:shadow transition p-4 flex items-center gap-3">
                        <div class="bg-blue-100 text-blue-800 rounded-full p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-5H3v5a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Timecards</h3>
                            <p class="text-xs text-gray-500">Submit & view attendance</p>
                        </div>
                    </a>

                    <!-- Generate Monthly Attendance PDF Card - Compact version -->
                    <div class="rounded-lg border-2 border-blue-300 bg-white shadow-sm p-4 flex items-center gap-3">
                        <div class="bg-blue-100 text-blue-800 rounded-full p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
    <h3 class="font-medium text-gray-800 mb-1 text-sm sm:text-base">Monthly Report</h3>
    <form action="{{ route('patrol.attendance.download') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2">
        <input type="month" id="month" name="month" required 
               class="text-xs border border-gray-300 rounded px-2 py-1 w-full sm:w-auto">
        <button type="submit"
            class="text-xs px-4 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 transition w-full sm:w-auto">
            Download
        </button>
    </form>
</div>
                    </div>
                </div>
            </div>

            <!-- New Chart Section -->
            <div class="bg-white shadow rounded-xl border border-blue-100 p-4">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <h2 class="text-lg font-semibold text-blue-800">Monthly Timecards Overview ({{ now()->format('Y') }})</h2>
                </div>
                <div class="h-64">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Timecards Submissions',
                data: [],
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderColor: 'rgba(59, 130, 246, 0.8)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Submissions'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            }
        }
    });

     async function fetchMonthlyData() {
    const currentYear = new Date().getFullYear();
    
    try {
        const response = await fetch(`/patrol/monthly-attendance-counts?year=${currentYear}`);
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        chart.data.datasets[0].data = data.counts;
        chart.update();
    } catch (error) {
        console.error('Error fetching attendance data:', error);
        // Optional: Show error to user
        alert('Failed to load attendance data. Please try again later.');
    }
}
fetchMonthlyData();
});
</script>
@endpush
@endsection