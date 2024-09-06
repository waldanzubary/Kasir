@extends('Layout.user_dashboard')

@section('title', 'UMKM Transactions')

@section('content')

<div class="container mx-auto p-6">
    <!-- Filter Form -->
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8 transition-transform transform hover:scale-105 duration-300 ease-in-out">
        <form action="{{ route('sales.transactions') }}" method="GET" class="flex flex-col md:flex-row gap-4 mb-2">
            <div class="flex-1">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full border border-gray-300 p-2 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-150 ease-in-out">
            </div>
            <div class="flex-1">
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-150 ease-in-out">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn bg-green-600 text-white hover:bg-green-700 transition duration-150 ease-in-out">Filter</button>
            </div>
        </form>
    </div>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Main Content -->
        <div class="flex-1 w-full lg:w-3/4">
            <!-- Stats Section -->
            <div class="rounded-lg mb-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                    @foreach ([
                        ['icon' => 'fa-people-carry-box', 'color' => '#63E6BE', 'label' => 'Total Transactions', 'value' => $totalTransactions],
                        ['icon' => 'fa-truck-ramp-box', 'color' => '#74C0FC', 'label' => 'Total Items', 'value' => $totalItems],
                        ['icon' => 'fa-coins', 'color' => '#FFD43B', 'label' => 'Total Gain', 'value' => 'Rp. ' . $totalSpent]
                    ] as $stat)
                        <div class="bg-white p-6 rounded-lg shadow-lg w-full transition-transform transform hover:scale-105 duration-300 ease-in-out">
                            <div class="flex items-center space-x-4">
                                <div class="stat-figure text-secondary">
                                    <i class="fa-solid {{ $stat['icon'] }} text-2xl" style="color: {{ $stat['color'] }};"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-600">{{ $stat['label'] }}</div>
                                    <div class="text-2xl font-bold text-gray-800">{{ $stat['value'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg mb-8 transition-transform transform hover:scale-105 duration-300 ease-in-out">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Monthly Sales</h2>
                <div class="relative w-full h-64 md:h-96">
                    <canvas id="monthlySalesChart"></canvas>
                </div>
            </div>

            <!-- Sales Transactions Section -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    @if($sales->isEmpty())
                        <p class="text-center text-gray-500">No transactions found.</p>
                    @else
                        <a href="{{ route('sales.exportPDF', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn bg-rose-600 text-white hover:bg-rose-700 transition duration-150 ease-in-out">Export as PDF</a>
                    @endif
                </div>
                <div class="overflow-x-auto rounded-lg shadow-lg">
                    <table class="min-w-full bg-white divide-y divide-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach(['Transaction', 'Date', 'Payment Method', 'Total Price', 'Action'] as $header)
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($sales as $sale)
                                <tr class="transition-transform transform hover:scale-105 duration-300 ease-in-out">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($sale->sale_date)->format('F Y') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->payment }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp. {{ $sale->total_price }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('sales.show', $sale->id) }}" class="text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out">See more</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="w-full lg:w-1/4 bg-white rounded-lg p-6 lg:sticky lg:top-0 transition-transform transform hover:scale-105 duration-300 ease-in-out">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Sales Overview</h2>
            <div class="relative w-full h-64 flex justify-center">
                <canvas id="salesOverviewChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Sales Chart
        const ctxMonthlySales = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(ctxMonthlySales, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Total Sales',
                    data: @json($amounts),
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
                                return 'Rp. ' + tooltipItem.raw.toLocaleString(); // Format numbers with currency
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
                                return 'Rp. ' + value.toLocaleString(); // Format numbers with currency
                            }
                        }
                    }
                }
            }
        });

        // Sales Overview Chart
        const ctxSalesOverview = document.getElementById('salesOverviewChart').getContext('2d');
        new Chart(ctxSalesOverview, {
            type: 'pie', // Use 'pie' or 'doughnut' based on your preference
            data: {
                labels: @json($paymentMethodLabels),
                datasets: [{
                    data: @json($paymentMethodCounts),
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.5)', // Example colors
                        'rgba(34, 197, 94, 0.5)',
                        'rgba(248, 113, 113, 0.5)',
                        'rgba(251, 146, 60, 0.5)',
                        'rgba(14, 165, 233, 0.5)'
                    ],
                    borderColor: [
                        '#4f46e5', // Example border colors
                        '#22c55e',
                        '#f87171',
                        '#f59e0b',
                        '#0ea5e9'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString(); // Format numbers
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
