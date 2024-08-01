<!DOCTYPE html>
<html>
<head>
    <title>Create Sale</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-end"><h1 class="mb-4">Create Sale | BARCODE</h1>
            <a href="create" class="d-sm-inline-block btn btn-sm  shadow-sm" style="background-color: rgba(116, 101, 194, 1); color:white; ">
                <i class="fa fa-book fa-sm text-white-50"></i> Manual
            </a>
        </div>


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form id="saleForm" action="{{ route('sales.store') }}" method="POST">
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

            <!-- Hidden input to track confirmation -->
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
                            $('#barcode_input').val(''); // Clear the input field
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
                        <input type="number" name="items[${itemCount}][quantity]" class="form-control" value="1" min="1" onchange="updatePrice(${itemCount}, ${item.price})" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" name="items[${itemCount}][price]" class="form-control" value="${item.price}" readonly>
                    </div>
                    <div class="form-group col-md-1">
                        <button type="button" class="btn btn-danger" onclick="removeItem('${itemId}')">Remove</button>
                    </div>
                </div>
            `;
            container.append(itemDiv);
            updateTotalPrice();
            itemCount++;
        }

        function removeItem(itemId) {
            $(`#${itemId}`).remove();
            updateTotalPrice();
        }

        function updatePrice(index, pricePerItem) {
            const quantity = $(`input[name="items[${index}][quantity]"]`).val();
            const totalItemPrice = pricePerItem * quantity;
            $(`input[name="items[${index}][price]"]`).val(totalItemPrice.toFixed(2));
            updateTotalPrice();
        }

        function updateTotalPrice() {
            let totalPrice = 0;
            $('input[name$="[price]"]').each(function() {
                totalPrice += parseFloat($(this).val()) || 0;
            });
            $('#total_price').val(totalPrice.toFixed(2));
        }

        function confirmSale() {
            const totalPrice = document.getElementById('total_price').value;
            const isConfirmed = confirm(`Are you sure you want to submit this sale with a total price of $${totalPrice}?`);

            if (isConfirmed) {
                // Set the hidden input's value to true
                document.getElementById('isConfirmed').value = "true";
                // Submit the form
                document.getElementById('saleForm').submit();
            }
        }
    </script>
</body>
</html>
