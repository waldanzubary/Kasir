@extends('Layout.user_dashboard')

@section('title', 'UMKM Transactions')

@section('content')




</head>

<body>
    <div class="mx-auto p-6">

    <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full bg-white divide-y divide-gray-200 rounded-lg shadow-lg ">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>

                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($sale->salesItems as $salesItem)
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $salesItem->item->itemName }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $salesItem->quantity }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $salesItem->price }}</td>

                    </tr>
                @endforeach
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total : </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                <th class="px-4 py-3 text-left text-sm font-bold text-gray-500 uppercase tracking-wider">{{ $sale->total_price }}</th>


            </tbody>



        </table>
    </div>
</div>



        @endsection


