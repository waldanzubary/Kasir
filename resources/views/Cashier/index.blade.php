<!DOCTYPE html>
<html>
<head>
    <title>Create Sale</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Create Sale</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="sale_date">Sale Date:</label>
                <input type="date" id="sale_date" name="sale_date" class="form-control" required>
            </div>

            <div id="items-container">
                <div class="item form-row" id="item-0">
                    <div class="form-group col-md-4">
                        <label for="items[0][item_id]">Item:</label>
                        <select id="items[0][item_id]" name="items[0][item_id]" class="form-control" onchange="updatePrice(0)" required>
                            <option value="">Select an item</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->price }}">{{ $item->itemName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="items[0][quantity]">Quantity:</label>
                        <input type="number" id="items[0][quantity]" name="items[0][quantity]" class="form-control" min="1" value="1" onchange="updatePrice(0)" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="items[0][price]">Price:</label>
                        <input type="text" id="items[0][price]" name="items[0][price]" class="form-control" readonly>
                    </div>

                    <div class="form-group col-md-1 mt-2">
                        <button type="button" class="btn btn-danger mt-4" onclick="removeItem('item-0')">Remove</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="total_price">Total Price:</label>
                <input type="text" id="total_price" name="total_price" class="form-control" readonly>
            </div>

            <button type="button" class="btn btn-secondary" onclick="addItem()">Add More Items</button>
            <button type="submit" class="btn btn-primary">Submit Sale</button>
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


    
    <script>
        let itemCount = 1;

        function addItem() {
            const container = document.getElementById('items-container');
            const itemDiv = document.createElement('div');
            const itemId = `item-${itemCount}`;
            itemDiv.classList.add('item', 'form-row', 'mt-1');
            itemDiv.setAttribute('id', itemId);
            itemDiv.innerHTML = `
                <div class="form-group col-md-4">
                    <select id="items[${itemCount}][item_id]" name="items[${itemCount}][item_id]" class="form-control" onchange="updatePrice(${itemCount})" required>
                        <option value="">Select an item</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}" data-price="{{ $item->price }}">{{ $item->itemName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <input type="number" id="items[${itemCount}][quantity]" name="items[${itemCount}][quantity]" class="form-control" min="1" value="1" onchange="updatePrice(${itemCount})" required>
                </div>

                <div class="form-group col-md-4">
                    <input type="text" id="items[${itemCount}][price]" name="items[${itemCount}][price]" class="form-control" readonly>
                </div>

                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-danger" onclick="removeItem('${itemId}')">Remove</button>
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
            const quantity = quantityInput.value;

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
</body>
</html>
