<!DOCTYPE html>
<html>
<head>
    <title>Create Sale</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-end">
            <h1 class="mb-4">Create Sale | BARCODE</h1>
            <a href="{{ route('sales.create') }}" class="d-sm-inline-block btn btn-sm shadow-sm" style="background-color: rgba(116, 101, 194, 1); color:white;">
                <i class="fa fa-book fa-sm text-white-50"></i> Manual
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form id="saleForm" action="{{ route('sales.stores') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="sale_date">Sale Date:</label>
                <input type="date" id="sale_date" name="sale_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="buyer_id">Buyer:</label>
                <select id="buyer_id" name="buyer_id" class="form-control">
                    <option value="">Select a buyer (optional)</option>
                    @foreach ($buyers as $buyer)
                        <option value="{{ $buyer->id }}">{{ $buyer->username }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="payment">Payment Method:</label>
                <select id="payment" name="payment" class="form-control" required>
                    <option value="Cash">Cash</option>
                    <option value="E-Wallet">E-Wallet</option>
                    <option value="Bank">Bank</option>
                </select>
            </div>

            <div class="form-group">
                <label for="barcode_input">Scan Barcode:</label>
                <input type="text" id="barcode_input" name="barcode" class="form-control" placeholder="Scan barcode here">
            </div>

            <div id="items-container">
                <!-- Dynamic Items Will be Added Here -->
            </div>

            <div class="form-group">
                <label for="total_price">Total Price:</label>
                <input type="text" id="total_price" name="total_price" class="form-control" readonly>
            </div>

            <input type="hidden" id="isConfirmed" name="isConfirmed" value="false">

            <button type="button" class="btn btn-primary" onclick="confirmSale()">Submit Sale</button>
        </form>

        <h2 class="mt-5">Sales Data</h2>

        <table class="table table-bordered mt-3">
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
                <div class="item form-row mt-1" id="${itemId}">
                    <div class="form-group col-md-4">
                        <input type="hidden" name="items[${itemCount}][item_id]" value="${item.id}">
                        <input type="text" class="form-control" value="${item.itemName}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="number" name="items[${itemCount}][quantity]" class="form-control" value="1" min="1" max="${item.stock}" oninput="updateItemStock(${itemCount}, ${item.stock})">
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="items[${itemCount}][price]" class="form-control" value="${item.price}" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="button" class="btn btn-danger" onclick="removeItem('${itemId}')">Remove</button>
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
</body>
</html>
