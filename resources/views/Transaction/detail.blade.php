@extends('Layout.content')

@section('title', 'Sales Transactions')

@section('content')

    <style>


        .transaction-row {
            background-color: #2D3748;
            color: #E2E8F0;
        }
        .transaction-row td, .transaction-row th {
            padding: 15px;
        }

        .transaction-row td {
            border-bottom: 1px solid #1a202c;
        }
        .transaction-details {
            font-weight: bold;
            margin-bottom: 20px;
        }
        .total-price {
            font-size: 1.25rem;
            font-weight: bold;
            background-color: #2D3748;
            color: #E2E8F0;
            padding: 15px;
            text-align: right;
        }
        .card {
            margin-top: 30px;
            background-color: #1a202c;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .card img {
            border-radius: 8px;
        }
        .card p {
            margin: 0;
        }
        .table tr:hover {
            background-color: #4A5568;
        }
    </style>
</head>

<body>


        <div class="card">
            <h2 class="text-lg font-bold mb-4">Transaction Details</h2>
            <table class="table w-full">
              <!-- head -->
              <thead>
                <tr class="transaction-row">
                  <th>Name</th>
                  <th>Quantity</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>
                <!-- Sales Items Rows -->
                @foreach ($sale->salesItems as $salesItem)
                <tr class="transaction-row">
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar">
                        <div class="mask mask-squircle h-12 w-12">
                          <img
                            src="{{ asset('storage/' . $salesItem->item->image) }}"
                            alt="Item Image" />
                        </div>
                      </div>
                      <div>
                        <div class="font-bold">{{ $salesItem->item->itemName }}</div>
                      </div>
                    </div>
                  </td>
                  <td>{{ $salesItem->quantity }}</td>
                  <td>{{ $salesItem->price }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="total-price mt-4">
                Total : {{ $sale->total_price }}
            </div>
        </div>

        @endsection


</body>
</html>
