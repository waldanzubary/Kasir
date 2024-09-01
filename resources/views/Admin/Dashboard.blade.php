@extends('Layout.admin_dashboard')

@section('title', 'Sales Transactions')

@section('content')

<div class="container mx-auto p-6">
     <!-- Filter Form -->

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Main Content -->


        <div class="flex-1 w-full lg:w-3/4">
            <!-- Stats Section -->
            <div class="rounded-lg mb-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
                        <div class="flex items-center space-x-4">
                            <div class="stat-figure text-secondary">
                                <i class="fa-solid fa-user text-2xl" style="color: #63E6BE;"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-600">Total User active</div>
                                <div class="text-2xl font-bold text-gray-800">{{ $totalActiveUsers }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
                        <div class="flex items-center space-x-4">
                            <div class="stat-figure text-secondary">
                                <i class="fa-solid fa-user text-2xl" style="color: #f33535;"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-600">Total User inactive</div>
                                <div class="text-2xl font-bold text-gray-800">{{ $totalInactiveUsers }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
                        <div class="flex items-center space-x-4">
                            <div class="stat-figure text-secondary">
                                <i class="fa-solid fa-user text-2xl" style="color: #242424;"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-600">Total User</div>
                                <div class="text-2xl font-bold text-gray-800">{{ $totalMembership }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">User statitic</h2>
                <div class="relative w-full h-64 md:h-96">
                    <canvas id="monthlySalesChart"></canvas>
                </div>
            </div>





        </div>

        <!-- Right Sidebar -->
        <div class="w-full lg:w-1/4 bg-white rounded-lg p-6 lg:sticky lg:top-0">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Account overview</h2>
            <div class="relative w-full h-64 flex justify-center">
                <canvas id="salesOverviewChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        // Monthly New Users Chart
        const ctxMonthlyNewUsers = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(ctxMonthlyNewUsers, {
            type: 'bar',
            data: {
                labels: ['This Month'], // Label for this month's account creation count
                datasets: [{
                    label: 'New Accounts',
                    data: [@json($monthlyNewUsers)], // Data point for this month's new accounts
                    backgroundColor: 'rgba(79, 70, 229, 0.5)', // Soft purple
                    borderColor: '#4f46e5', // Dark purple
                    borderWidth: 2,
                    barThickness: 28, // Width of each bar
                    borderRadius: 8, // Rounded corners
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Hide the legend if not needed
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + ' new accounts'; // Tooltip text
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Month',
                            color: '#4a5568'
                        },
                        ticks: {
                            color: '#4a5568',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderColor: '#e2e8f0',
                            borderWidth: 1
                        },
                        ticks: {
                            color: '#4a5568',
                            font: {
                                weight: 'bold'
                            },
                            callback: function(value) {
                                return value + ' accounts'; // Format y-axis labels
                            }
                        }
                    }
                }
            }
        });

        // Active vs. Inactive Users Chart
        const ctxUserStatus = document.getElementById('salesOverviewChart').getContext('2d');
        new Chart(ctxUserStatus, {
            type: 'pie',
            data: {
                labels: ['Active Users', 'Inactive Users'],
                datasets: [{
                    data: [@json($totalActiveUsers), @json($totalInactiveUsers)], // Data for active and inactive users
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.5)', // Green for active users
                        'rgba(239, 68, 68, 0.5)'  // Red for inactive users
                    ],
                    borderColor: [
                        '#16a34a', // Border color for active users
                        '#ef4444'  // Border color for inactive users
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString() + ' users'; // Tooltip text
                            }
                        }
                    }
                }
            }
        });
    });


</script>

@endsection
