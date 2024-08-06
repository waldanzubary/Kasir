<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Details</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Include your CSS file --> --}}
</head>
<body>
    <div class="container">
        <h1>Sale Details</h1>
        <div class="sale-info">
            <p><strong>User:</strong> {{ $sale->user->name }}</p>
            <p><strong>Buyer ID:</strong> {{ $sale->buyer_id }}</p>
            <p><strong>Sale Date:</strong> {{ $sale->sale_date }}</p>
            <p><strong>Total Price:</strong> ${{ $sale->total_price }}</p>
            <p><strong>Payment:</strong> {{ $sale->payment }}</p>
        </div>

        <h2>Items Sold</h2>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->salesItems as $salesItem)
                    <tr>
                        <td>{{ $salesItem->item->itemName }}</td>
                        <td>{{ $salesItem->quantity }}</td>
                        <td>${{ $salesItem->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        // Function to refresh the page every 1 second
        function refreshPage() {
            window.location.reload();
        }

        // Set the interval to call refreshPage every 1000 milliseconds (1 second)
        setInterval(refreshPage, 1000);
    </script>
</body>
</html>
