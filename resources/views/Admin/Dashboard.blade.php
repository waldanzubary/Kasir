@extends('Layout.admin_dashboard')

@section('title', 'Sales Transactions')

@section('content')



<style>
    .blues {
        color: rgba(75, 192, 192, 1);
    }
    .yellow{
        color: rgb(211, 211, 94)
    }
</style>
<div class="stats shadow justify-center flex">
    <div class="stat place-items-center ">
        <div class="stat-title">Total Revenue / month</div>
        <div class="stat-value yellow">Rp. {{ $totalRevenue }}</div>
        <div class="stat-desc">From {{ $startOfMonth->format('F jS') }} to {{ $endOfMonth->format('F jS') }}</div>
    </div>

    <div class="stat place-items-center">
        <div class="stat-title">Total items sold / month</div>
        <div class="stat-value">{{ $totalItemsSold }}</div>
        <div class="stat-desc">From {{ $startOfMonth->format('F jS') }} to {{ $endOfMonth->format('F jS') }}</div>
    </div>

    <div class="stat place-items-center">
        <div class="stat-title">Total membership (user role)</div>
        <div class="stat-value">{{ $totalMembership }}</div>
        <div class="stat-desc">↘︎ {{ $totalMembershipChange }} (14%)</div>
    </div>
</div>

<div class="chart-container mt-6">
    <canvas id="monthlySalesChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlySales->keys()),
                datasets: [{
                    label: 'Monthly Sales',
                    data: @json($monthlySales->values()),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
