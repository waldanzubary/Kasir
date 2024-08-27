@extends('Layout.user_dashboard')

@section('title', 'Sales Transactions')

@section('content')

<div class="container mx-auto p-6">
     <!-- Filter Form -->
     <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <form action="{{ route('sales.transactions') }}" method="GET" class="flex flex-col md:flex-row gap-4 mb-2">
            <div class="flex-1">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full border border-gray-300 p-2 rounded-lg shadow-sm">
            </div>
            <div class="flex-1">
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full border border-gray-300 rounded-lg  p-2 shadow-sm">
            </div>
            <div class="flex items-end ">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Main Content -->


        <div class="flex-1 w-full lg:w-3/4">
            <!-- Stats Section -->
            <div class="rounded-lg mb-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
                        <div class="flex items-center space-x-4">
                            <div class="stat-figure text-secondary">
                                <i class="fa-solid fa-people-carry-box text-2xl" style="color: #63E6BE;"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-600">Total Transactions</div>
                                <div class="text-2xl font-bold text-gray-800">{{ $totalTransactions }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
                        <div class="flex items-center space-x-4">
                            <div class="stat-figure text-secondary">
                                <i class="fa-solid fa-truck-ramp-box text-2xl" style="color: #74C0FC;"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-600">Total Items</div>
                                <div class="text-2xl font-bold text-gray-800">{{ $totalItems }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
                        <div class="flex items-center space-x-4">
                            <div class="stat-figure text-secondary">
                                <i class="fa-solid fa-coins text-2xl" style="color: #FFD43B;"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-600">Total Gain</div>
                                <div class="text-2xl font-bold text-gray-800">Rp. {{ $totalSpent }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
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
                        <a href="{{ route('sales.exportPDF', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn bg-rose-500 text-white">Export as PDF</a>
                    @endif
                </div>
                <div>

                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full bg-white divide-y divide-gray-200 rounded-lg shadow-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $loop->iteration }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($sale->sale_date)->format('F Y') }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->payment }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp. {{ $sale->total_price }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('sales.show', $sale->id) }}" class="text-blue-600 hover:text-blue-800">See more</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="w-full lg:w-1/4 bg-white rounded-lg p-6 lg:sticky lg:top-0">
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
                        title: {
                            display: true,
                            text: 'Total Sales',
                            color: '#4a5568'
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
            type: 'doughnut',
            data: {
                labels: @json($overviewLabels),
                datasets: [{
                    label: 'Sales Overview',
                    data: @json($overviewValues),
                    backgroundColor: ['#4f46e5', '#10b981', '#f59e0b'], // Example colors
                    borderColor: '#ffffff',
                    borderWidth: 1
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
                                return tooltipItem.label + ': Rp. ' + tooltipItem.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
