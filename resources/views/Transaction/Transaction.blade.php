<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Transactions</title>
</head>
<body>
    @csrf

    <h1>Sales Transactions</h1>

    @if($sales->isEmpty())
        <p>No transactions found.</p>
    @else
        @foreach ($sales as $sale)
            <div>
                <h2>Sale Date: {{ $sale->sale_date }}</h2>
                <p>Cashier: {{ $sale->user->username }}</p>
                <p>Payment Method: {{ $sale->payment }}</p>
                <p>Total Price: {{ $sale->total_price }}</p>
                <a href="{{ route('sales.show', $sale->id) }}">See more</a>
            </div>
        @endforeach
    @endif
</body>
</html>
