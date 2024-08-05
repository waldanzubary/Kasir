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
            <h1 class="text-3xl font-bold">Create Sale | MANUAL</h1>
            <a href="creates" class="btn btn-primary">
                <i class="fa fa-barcode"></i> Barcode
            </a>
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

        <form action="{{ route('sales.store') }}" method="POST">
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
                <select id="payment" name="payment" class="select select-bordered" required>
                    <option value="Cash">Cash</option>
                    <option value="E-Wallet">E-Wallet</option>
                    <option value="Bank">Bank</option>
                </select>
            </div>

            <div id="items-container">
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
                            <label for="items[0][delegte]" class="label">
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

    <script>
        let itemCount = 1;

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
            const pricePerItem = selectedItem ? selectedItem.getAttribute('data-price') : 0;
            const stock = selectedItem ? selectedItem.getAttribute('data-stock') : 0;
            const quantity = quantityInput.value;

            if (quantity > stock) {
                alert(`Insufficient stock for ${selectedItem.text}. Only ${stock} items available.`);
                quantityInput.value = stock; // Set quantity to maximum available
                priceInput.value = (pricePerItem * stock).toFixed(2);
                updateTotalPrice();
                return;
            }

            const totalItemPrice = pricePerItem * quantity;
            priceInput.value = totalItemPrice.toFixed(2);

            updateTotalPrice();
        }

        function updateTotalPrice() {
            let totalPrice = 0;

            const priceInputs = document.querySelectorAll(`#items-container .item input[id^="items"][id$="[price]"]`);
            priceInputs.forEach(priceInput => {
                totalPrice += parseFloat(priceInput.value) || 0;
            });

            document.getElementById('total_price').value = totalPrice.toFixed(2);
        }
    </script>
    @endsection
</body>
</html>
