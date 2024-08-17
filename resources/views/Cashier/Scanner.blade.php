@extends('Layout.content')

@section('title', 'Sales Transactions')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Create Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="">
    <div class="container mx-auto mt-8 p-4 bg-base-100 rounded-lg shadow-lg">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Create Sale</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="saleForm" action="{{ route('sales.store') }}" method="POST">
            @csrf

            <div class="form-control mb-4">
                <label for="sale_date" class="label">
                    <span class="label-text">Sale Date:</span>
                </label>
                <input type="date" id="sale_date" name="sale_date" class="input input-bordered" required>
            </div>

            <div class="form-control mb-4">
                <label for="buyer_id" class="label">
                    <span class="label-text">Buyer:</span>
                </label>
                <select id="buyer_id" name="buyer_id" class="select select-bordered">
                    <option value="">Select a buyer</option>
                    @foreach ($buyers as $buyer)
                        <option value="{{ $buyer->id }}">{{ $buyer->username }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-control mb-4">
                <label for="payment" class="label">
                    <span class="label-text">Payment Method:</span>
                </label>
                <select id="payment" name="payment" class="select select-bordered" required onchange="toggleCashFields()">
                    <option value="Cash">Cash</option>
                    <option value="E-Wallet">E-Wallet</option>
                    <option value="Bank">Bank</option>
                </select>
            </div>

            <div class="form-control mb-4">
                <label for="barcode_input" class="label">
                    <span class="label-text">Scan Barcode:</span>
                </label>
                <input type="text" id="barcode_input" name="barcode" class="input input-bordered" placeholder="Scan barcode here">
            </div>

            <div id="items-container">
                <!-- Existing item inputs go here -->
                <div class="item form-control mb-4" id="item-0">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                        <div class="form-control">
                            <label for="items[0][item_id]" class="label">
                                <span class="label-text">Item:</span>
                            </label>
                            <select id="items[0][item_id]" name="items[0][item_id]" class="select select-bordered" onchange="updatePrice(0)" required>
                                <option value="">Select an item</option>
                                @foreach ($items as $item)
                                    @if ($item->isInStock())
                                        <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-stock="{{ $item->stock }}">{{ $item->itemName }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-control">
                            <label for="items[0][quantity]" class="label">
                                <span class="label-text">Quantity:</span>
                            </label>
                            <input type="number" id="items[0][quantity]" name="items[0][quantity]" class="input input-bordered" min="1" value="1" onchange="updatePrice(0)" required>
                        </div>

                        <div class="form-control">
                            <label for="items[0][price]" class="label">
                                <span class="label-text">Price:</span>
                            </label>
                            <input type="text" id="items[0][price]" name="items[0][price]" class="input input-bordered" readonly>
                        </div>

                        <div class="">
                            <label for="items[0][delegate]" class="label">
                                <span class="label-text">Action :</span>
                            </label>
                            <button type="button" class="btn btn-error" onclick="removeItem('item-0')">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-control mb-4">
                <label for="total_price" class="label">
                    <span class="label-text">Total Price:</span>
                </label>
                <input type="text" id="total_price" name="total_price" class="input input-bordered" readonly>
            </div>

            <!-- Cash Fields -->
            <div id="cash-fields" class="hidden">
                <div class="form-control mb-4">
                    <label for="cash_amount" class="label">
                        <span class="label-text">Nominal Cash:</span>
                    </label>
                    <input type="number" id="cash_amount" name="cash_amount" class="input input-bordered" min="0" onchange="calculateChange()">
                </div>

                <div class="form-control mb-4">
                    <label for="change_amount" class="label">
                        <span class="label-text">Change:</span>
                    </label>
                    <input type="text" id="change_amount" name="change_amount" class="input input-bordered" readonly>
                </div>
            </div>
            <!-- End of Cash Fields -->

            <div class="flex gap-4">
                <button type="button" class="btn btn-secondary" onclick="addItem()">Add More Items</button>
                <button type="submit" class="btn btn-primary">Submit Sale</button>
            </div>
        </form>

        <h2 class="text-2xl font-bold mt-8">Sales Data</h2>

        <table class="table w-full mt-4">
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
        let itemCount = 1;

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
                            addItemFromBarcode(response.item);
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

        function addItem() {
            const container = document.getElementById('items-container');
            const itemDiv = document.createElement('div');
            const itemId = `item-${itemCount}`;
            itemDiv.classList.add('item', 'form-control', 'mb-4');
            itemDiv.setAttribute('id', itemId);
            itemDiv.innerHTML = `
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <div class="form-control">
                        <select id="items[${itemCount}][item_id]" name="items[${itemCount}][item_id]" class="select select-bordered" onchange="updatePrice(${itemCount})" required>
                            <option value="">Select an item</option>
                            @foreach ($items as $item)
                                @if ($item->isInStock())
                                    <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-stock="{{ $item->stock }}">{{ $item->itemName }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <input type="number" id="items[${itemCount}][quantity]" name="items[${itemCount}][quantity]" class="input input-bordered" min="1" value="1" onchange="updatePrice(${itemCount})" required>
                    </div>

                    <div class="form-control">
                        <input type="text" id="items[${itemCount}][price]" name="items[${itemCount}][price]" class="input input-bordered" readonly>
                    </div>

                    <div class=" ">
                        <button type="button" class="btn btn-error" onclick="removeItem('${itemId}')">Remove</button>
                    </div>
                </div>
            `;
            container.appendChild(itemDiv);
            itemCount++;
        }

        function addItemFromBarcode(item) {
            const container = document.getElementById('items-container');
            const itemId = `item-${itemCount}`;
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('item', 'form-control', 'mb-4');
            itemDiv.setAttribute('id', itemId);
            itemDiv.innerHTML = `
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <div class="form-control">
                        <input type="hidden" name="items[${itemCount}][item_id]" value="${item.id}">
                        <input type="text" class="input input-bordered w-full" value="${item.itemName}" readonly>
                    </div>
                    <div class="form-control">
                        <input type="number" name="items[${itemCount}][quantity]" class="input input-bordered w-full" value="1" min="1" max="${item.stock}" onchange="updatePrice(${itemCount})">
                    </div>
                    <div class="form-control">
                        <input type="text" name="items[${itemCount}][price]" class="input input-bordered w-full" value="${item.price}" readonly>
                    </div>
                    <div class="flex items-center">
                        <button type="button" class="btn btn-error" onclick="removeItem('${itemId}')">Remove</button>
                    </div>
                </div>
            `;
            container.appendChild(itemDiv);
            itemCount++;
            updateTotalPrice();
        }

        function removeItem(itemId) {
            const itemDiv = document.getElementById(itemId);
            itemDiv.remove();
            updateTotalPrice();
        }

        function updatePrice(index) {
            const itemSelect = document.getElementById(`items[${index}][item_id]`);
            const quantityInput = document.getElementById(`items[${index}][quantity]`);
            const priceInput = document.getElementById(`items[${index}][price]`);

            const selectedItem = itemSelect.options[itemSelect.selectedIndex];
            const price = parseFloat(selectedItem.getAttribute('data-price')) || 0;
            const quantity = parseInt(quantityInput.value) || 1;

            const totalPrice = price * quantity;
            priceInput.value = totalPrice.toFixed(2);

            updateTotalPrice();
        }

        function updateTotalPrice() {
            let totalPrice = 0;
            document.querySelectorAll('.item').forEach(item => {
                const price = parseFloat(item.querySelector('[id$="\\[price\\]"]').value) || 0;
                totalPrice += price;
            });
            document.getElementById('total_price').value = totalPrice.toFixed(2);
            calculateChange();
        }

        function toggleCashFields() {
            const paymentMethod = document.getElementById('payment').value;
            const cashFields = document.getElementById('cash-fields');

            if (paymentMethod === 'Cash') {
                cashFields.classList.remove('hidden');
            } else {
                cashFields.classList.add('hidden');
            }
        }

        function calculateChange() {
            const cashAmount = parseFloat(document.getElementById('cash_amount').value) || 0;
            const totalPrice = parseFloat(document.getElementById('total_price').value) || 0;
            const changeAmount = cashAmount - totalPrice;
            document.getElementById('change_amount').value = changeAmount.toFixed(2);
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateTotalPrice();
            toggleCashFields();
        });
    </script>
</body>
</html>
@endsection