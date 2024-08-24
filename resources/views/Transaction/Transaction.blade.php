@extends('Layout.user_dashboard')

@section('title', 'Sales Transactions')

@section('content')

<style>
    .stats {
        display: flex;
        margin-top: 25px;
        gap: 20px;
    }

    .cards-container {
        display: flex;
        flex-wrap: wrap;
        margin-top: 25px;
        justify-content: flex-start; /* Align cards to the left */
        gap: 20px;
    }

    .card {
        transition: transform 0.2s, box-shadow 0.2s;
        width: 100%;
        max-width: 320px;
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        font-weight: bold;
        border: 1px solid #e2e8f0;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .card-header {
        padding: 12px;
        font-weight: bold;
        background: #f7fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .card-body {
        padding: 16px;
    }

    .card-body p {
        margin: 8px 0;
        font-size: 14px;
        color: #4a5568;
    }

    .card-actions {
        padding: 12px;
        text-align: right;
        border-top: 1px solid #e2e8f0;
        background: #f7fafc;
    }

    .card-actions a {
        background-color: #3182ce;
        color: #ffffff;
        padding: 10px 16px;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.2s;
        font-weight: bold;
    }

    .card-actions a:hover {
        background-color: #2b6cb0;
    }

    .footer {
        margin-top: 30px;
    }
</style>

<div class="stats">
    <div class="stat">
        <div class="stat-figure text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="stat-title">Total Transactions</div>
        <div class="stat-value">{{ $totalTransactions }}</div>
        <div class="stat-desc">Jan 1st - Feb 1st</div>
    </div>

    <div class="stat">
        <div class="stat-figure text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
        </div>
        <div class="stat-title">Total Items</div>
        <div class="stat-value">{{ $totalItems }}</div>
    </div>

    <div class="stat">
        <div class="stat-figure text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
            </svg>
        </div>
        <div class="stat-title">Total Gain</div>
        <div class="stat-value">Rp. {{ number_format($totalSpent, 2, ',', '.') }}</div>
    </div>
</div>

<div class="cards-container">
    @if($sales->isEmpty())
        <p>No transactions found.</p>
    @else
        @foreach ($sales as $sale)
            <div class="card bg-base-200">
                <div class="card-header">
                    <h2>Sale Date: {{ $sale->sale_date }}</h2>
                </div>
                <div class="card-body">
                    <p>Cashier: {{ $sale->user->username }}</p>
                    <p>Payment Method: {{ $sale->payment }}</p>
                    <p>Total Price: Rp. {{ number_format($sale->total_price, 2, ',', '.') }}</p>
                </div>
                <div class="card-actions">
                    <a href="{{ route('sales.show', $sale->id) }}">See more</a>
                </div>
            </div>
        @endforeach
    @endif
</div>

@endsection
