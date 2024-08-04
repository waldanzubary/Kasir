@extends('Layout.content')

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
        justify-content: center;
        gap: 20px;

    }

    .card {
        transition: transform 0.2s, box-shadow 0.2s;
        width: 100%;
        max-width: 300px;
        border-radius: 8px;
        overflow: hidden;
        /* background: #2d3748; */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        font-weight: bold;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
    }

    .card-header {
        /* background: #1a202c; */
        padding: 10px;
        /* color: #e2e8f0; */
        font-weight: bold;

    }

    .card-body {
        padding: 20px;
    }

    .card-body p {
        margin: 10px 0;
    }

    .card-actions {
        padding: 20px;
        /* background: #1a202c; */
        text-align: right;
    }

    .card-actions a {
        background-color: #4a5568;
        color: #e2e8f0;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .card-actions a:hover {
        background-color: #2d3748;
    }

    .footer {
        margin-top: 30px;
    }
</style>

@csrf
<div class="stats  stats">
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
        <div class="stat-value">Rp. {{ $totalSpent }}</div>
    </div>
</div>

<div class="cards-container">
    @if($sales->isEmpty())
        <p>No transactions found.</p>
    @else
        @foreach ($sales as $sale)
            <div class="card  base-200">
                <div class="card-header bg-base-300 ">
                    <h2>Sale Date: {{ $sale->sale_date }}</h2>
                </div>
                <div class="card-body">
                    <p>Cashier: {{ $sale->user->username }}</p>
                    <p>Payment Method: {{ $sale->payment }}</p>
                    <p>Total Price: Rp. {{ $sale->total_price }}</p>
                </div>
                <div class="card-actions bg-base-200">
                    <a href="{{ route('sales.show', $sale->id) }}">See more</a>
                </div>
            </div>
        @endforeach
    @endif
</div>

@endsection
