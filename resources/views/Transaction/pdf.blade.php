<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .overflow-x-auto {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        thead {
            background-color: #f0f0f0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .text-sm {
            font-size: 0.875rem;
        }
        .font-medium {
            font-weight: 500;
        }
        .text-gray-500 {
            color: #6b7280;
        }
        .text-gray-900 {
            color: #111827;
        }
    </style>
</head>
<body>
    <h1>Sales Report</h1>
    @if($sales->isEmpty())
        <p>No sales data available.</p>
    @else
        <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($sale->sale_date)->format('F Y') }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->payment }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp. {{ $sale->total_price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</body>
</html>
