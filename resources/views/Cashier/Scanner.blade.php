@extends('Layout.content')

@section('title', 'Sales Transactions')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Create Sale</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daisyui@2.26.1/dist/full.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="">
    <div class="container mx-auto mt-8 p-4 bg-base-100 rounded-lg shadow-lg">
        <div class="flex justify-between items-end mb-4">
            <h1 class="text-2xl font-bold mb-4">Create Sale | BARCODE</h1>
            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                <i class="fa fa-book"></i> Manual
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form id="saleForm" action="{{ route('sales.stores') }}" method="POST" class="space-y-4">
            @csrf
            <div class="form-control">
                <label for="sale_date" class="label">Sale Date:</label>
                <input type="date" id="sale_date" name="sale_date" class="input input-bordered" required>
            </div>

            <div class="form-control">
                <label for="buyer_id" class="label">Buyer:</label>
                <select id="buyer_id" name="buyer_id" class="select select-bordered">
                    <option value="">Select a buyer (optional)</option>
                    @foreach ($buyers as $buyer)
                        <option value="{{ $buyer->id }}">{{ $buyer->username }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label for="payment" class="label">Payment Method:</label>
                <select id="payment" name="payment" class="select select-bordered" required>
                    <option value="Cash">Cash</option>
                    <option value="E-Wallet">E-Wallet</option>
                    <option value="Bank">Bank</option>
                </select>
            </div>

            <div class="form-control">
                <label for="barcode_input" class="label">Scan Barcode:</label>
                <input type="text" id="barcode_input" name="barcode" class="input input-bordered" placeholder="Scan barcode here">
            </div>

            <div id="items-container">
                <!-- Dynamic Items Will be Added Here -->
            </div>

            <div class="form-control">
                <label for="total_price" class="label">Total Price:</label>
                <input type="text" id="total_price" name="total_price" class="input input-bordered" readonly>
            </div>

            <input type="hidden" id="isConfirmed" name="isConfirmed" value="false">

            <button type="button" class="btn btn-primary" onclick="confirmSale()">Submit Sale</button>
        </form>

        <h2 class="text-xl font-bold mt-5">Sales Data</h2>

        <table class="table table-zebra mt-3 w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sale Date</th>
                    <th>Total Price</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->sale_date }}</td>
                        <td>{{ $sale->total_price }}</td>
                        <td>{{ $sale->user->username }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        let itemCount = 0;

        $(document).ready(function() {
            $('#barcode_input').on('change', function() {
                let barcode = $(this).val();

                $.ajax({
                    url: "{{ route('sales.barcode') }}",
                    type: "POST",
                    data: {
                        barcode: barcode,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            addItem(response.item);
                            $('#barcode_input').val('');
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Item not found');
                    }
                });
            });
        });

        function addItem(item) {
            const container = $('#items-container');
            const itemId = `item-${itemCount}`;
            const itemDiv = `
                <div class="item form-control  mt-2 " id="${itemId}">
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <input type="hidden" name="items[${itemCount}][item_id]" value="${item.id}">
                            <input type="text" class="input input-bordered w-full" value="${item.itemName}" readonly>
                        </div>
                        <div>
                            <input type="number" name="items[${itemCount}][quantity]" class="input input-bordered w-full" value="1" min="1" max="${item.stock}" oninput="updateItemStock(${itemCount}, ${item.stock})">
                        </div>
                        <div>
                            <input type="text" name="items[${itemCount}][price]" class="input input-bordered w-full" value="${item.price}" readonly>
                        </div>
                        <div class="flex items-center ">
                            <button type="button" class="btn btn-error" onclick="removeItem('${itemId}')">Remove</button>
                        </div>
                    </div>
                </div>
            `;
            container.append(itemDiv);
            itemCount++;
            updateTotalPrice();
        }

        function updateItemStock(index, stock) {
            const quantityInput = $(`input[name="items[${index}][quantity]"]`);
            const quantity = quantityInput.val();
            if (quantity > stock) {
                alert('Quantity exceeds available stock!');
                quantityInput.val(stock); // Set quantity to max stock value
            }
            updateTotalPrice();
        }

        function removeItem(id) {
            $(`#${id}`).remove();
            updateTotalPrice();
        }

        function updateTotalPrice() {
            let total = 0;
            $('#items-container .item').each(function() {
                const quantity = $(this).find('input[name$="[quantity]"]').val();
                const price = $(this).find('input[name$="[price]"]').val();
                total += quantity * price;
            });
            $('#total_price').val(total);
        }

        function confirmSale() {
            const form = $('#saleForm');
            const items = form.find('.item');
            let valid = true;

            items.each(function() {
                const quantity = $(this).find('input[name$="[quantity]"]').val();
                const maxStock = $(this).find('input[name$="[quantity]"]').attr('max');
                if (parseInt(quantity) > parseInt(maxStock)) {
                    valid = false;
                    alert('One or more items have quantities exceeding available stock.');
                    return false; // break the loop
                }
            });

            if (valid) {
                $('#isConfirmed').val('true');
                form.submit();
            }
        }
    </script>
    @endsection
</body>
</html>
