@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">
       

        <!-- Dashboard Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-blue-800">Admin Dashboard</h1>
        </div>

        <!-- Main Dashboard Card -->
        <div class="border-4 border-blue-900 rounded-2xl p-6 bg-white shadow-lg">
            <!-- Welcome Message -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Welcome Administrator,</h2>
                    <!-- Top Right Last Updated Timestamp -->
        <div class="flex justify-end mb-1">
            <div class="bg-white px-2 py-2 rounded-full border border-blue-600">
                <span class="text-sm text-black font-medium">Last updated: {{ now()->format('M d, Y h:i A') }}</span>
            </div>
        </div>

            </div>


         
            <!-- Sections: Companies & User Management -->
            <div class="space-y-10">
                <!-- Company and Location Stats -->
                <div>
                    <p class="text-lg font-medium text-gray-700 mb-2">Companies and Locations</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach([
                            ['name' => 'Locations', 'count' => \App\Models\Location::count(), 'route' => 'admin.locations.index'],
                            ['name' => 'Companies', 'count' => \App\Models\Company::count(), 'route' => 'admin.companies.index']
                        ] as $item)
                            <div class="bg-white hover:bg-cyan-50 rounded-xl border-2 border-blue-400 hover:border-blue-700 p-4 transform hover:scale-105 transition-all drop-shadow-md hover:drop-shadow-[0_4px_10px_rgba(59,130,246,0.8)]">
                                <h3 class="text-lg font-semibold text-black">{{ $item['name'] }}</h3>
                                <p class="text-3xl font-bold text-center">{{ $item['count'] }}</p>
                                <a href="{{ route($item['route']) }}" class="mt-3 inline-block bg-blue-900 hover:bg-blue-500 text-white text-sm px-3 py-1 rounded">
                                    View All
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- User Management Stats -->
                <div>
                    <p class="text-lg font-medium text-gray-700 mb-2">User Management</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach([
                            ['name' => 'Company Users', 'count' => \App\Models\CompanyUser::count(), 'route' => 'admin.company_users.index'],
                            ['name' => 'Approver DGMs', 'count' => \App\Models\ApproverDgm::count(), 'route' => 'admin.approver.index'],
                            ['name' => 'Security Managers', 'count' => \App\Models\SecurityManager::count(), 'route' => 'admin.security_managers.index'],
                            ['name' => 'Patrol Officers', 'count' => \App\Models\PatrolOfficer::count(), 'route' => 'admin.patrol_officers.index'],
                            ['name' => 'Security Officers', 'count' => \App\Models\SecurityOfficer::count(), 'route' => 'admin.security_officers.index']
                        ] as $item)
                            <div class="bg-white hover:bg-cyan-50 rounded-xl border-2 border-blue-400 hover:border-blue-700 p-4 transform hover:scale-105 transition-all drop-shadow-md hover:drop-shadow-[0_4px_10px_rgba(59,130,246,0.8)]">
                                <h3 class="text-lg font-semibold text-black">{{ $item['name'] }}</h3>
                                <p class="text-3xl font-bold text-center">{{ $item['count'] }}</p>
                                <a href="{{ route($item['route']) }}" class="mt-3 inline-block bg-blue-900 hover:bg-blue-500 text-white text-sm px-3 py-1 rounded">
                                    View All
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @php
                $companyUsers = \App\Models\CompanyUser::count();
                $approvers = \App\Models\ApproverDgm::count();
                $managers = \App\Models\SecurityManager::count();
                $patrols = \App\Models\PatrolOfficer::count();
                $officers = \App\Models\SecurityOfficer::count();
                $locations = \App\Models\Location::count();
            @endphp

            <!-- Chart + Calendar Section -->
            <div class="flex flex-col lg:flex-row gap-6 mt-10">
                <!-- Bar Chart -->
                <div class="w-full lg:flex-1 bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">User Roles</h2>
                    <div class="relative" style="height: 300px;">
                        <canvas id="userRoleChart"></canvas>
                    </div>
                </div>

                <!-- Calendar -->
                <div class="w-full lg:w-1/3 bg-blue-50 p-4 rounded-xl shadow-md">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg font-semibold text-black">Calendar</h2>
                        <span class="text-sm text-gray-500">{{ now()->format('F Y') }}</span>
                    </div>
                    <div class="grid grid-cols-7 gap-[2px] text-center text-[11px]">
                        @foreach(['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'] as $day)
                            <div class="aspect-square font-semibold text-gray-600 flex items-center justify-center bg-white rounded">
                                {{ $day }}
                            </div>
                        @endforeach
                        @php
                            $firstDayOfMonth = now()->startOfMonth()->dayOfWeek;
                            $daysInMonth = now()->daysInMonth;
                        @endphp
                        @for($i = 0; $i < $firstDayOfMonth; $i++)
                            <div class="aspect-square"></div>
                        @endfor
                        @for($day = 1; $day <= $daysInMonth; $day++)
                            <div class="aspect-square flex items-center justify-center text-xs font-medium rounded-md
                                {{ now()->day == $day ? 'bg-blue-700 text-white' : 'bg-white text-gray-800 hover:bg-blue-200 transition' }}">
                                {{ $day }}
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('userRoleChart').getContext('2d');

        const dataCounts = {
            companyUsers: {{ $companyUsers }},
            approvers: {{ $approvers }},
            managers: {{ $managers }},
            patrols: {{ $patrols }},
            officers: {{ $officers }},
            locations: {{ $locations }}
        };

        const totalUsers = Object.values(dataCounts).reduce((a, b) => a + b, 0);

        const percentValues = Object.values(dataCounts).map(count => {
            return totalUsers ? ((count / totalUsers) * 100).toFixed(2) : 0;
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Company Users', 'Approver DGMs', 'Security Managers', 'Patrol Officers', 'Security Officers', 'Locations'],
                datasets: [{
                    label: 'Percentage (%)',
                    data: percentValues,
                    backgroundColor: ['#8837c7', '#554be8', '#12ca7f', '#12abca', '#072395', '#facc15'],
                    borderColor: '#1e293b',
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 48,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: { color: '#374151', font: { size: 12 } },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: value => value + '%',
                            color: '#374151',
                            font: { size: 12 },
                            stepSize: 20
                        },
                        grid: {
                            color: 'rgba(107,114,128,0.2)',
                            drawBorder: false
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 8,
                        cornerRadius: 6,
                        callbacks: {
                            label: function(context) {
                                const percent = context.formattedValue + '%';
                                const count = Object.values(dataCounts)[context.dataIndex];
                                return percent + ' (' + count + ' users)';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
