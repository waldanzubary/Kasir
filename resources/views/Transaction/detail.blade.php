<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaction Details</title>
</head>
<body>
    <h1>Transaction Details</h1>
    <h2>Sale Date: {{ $sale->sale_date }}</h2>
    <p>Cashier: {{ $sale->user->username }}</p>
    <p>Payment Method: {{ $sale->payment }}</p>
    <p>Total Price: {{ $sale->total_price }}</p>

    <h3>Items:</h3>
    <ul>
        @foreach ($sale->salesItems as $salesItem)
            <li>
                {{ $salesItem->item->itemName }} - |
                Quantity: {{ $salesItem->quantity }} - |
                Price: {{ $salesItem->price }}
            </li>
        @endforeach
    </ul>

    <a href="{{ route('transaction.index') }}">Back to Sales</a>
</body>
</html>
