@extends('Layout.user_dashboard')

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
<body>
    <form id="saleForm" action="{{ route('sales.stores') }}" method="POST" class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4">
        @csrf
        <!-- Main Content -->
        <main class="flex-1 bg-white p-6 rounded-lg shadow-md">
            <div class="form-control mb-4">
                <label for="barcode_input" class="label font-semibold text-gray-700">Scan Barcode:</label>
                <input type="text" id="barcode_input" name="barcode" class="input input-bordered w-full" placeholder="Scan barcode here">
            </div>
                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <input type="hidden" id="isConfirmed" name="isConfirmed" value="false">

                <h2 class="text-xl font-bold mt-5 text-gray-800">List item</h2>
                @foreach ($items as $item)
                <button type="button" class="w-fit shadow-lg rounded-lg overflow-hidden m-2" onclick="addItem({{ json_encode($item) }})">
                    <figure>
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->itemName }}" class="object-cover w-36 h-36 rounded-t-lg">
                    </figure>
                    <div class="card-body p-4">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-bold">{{ $item->itemName }}</h2>
                        </div>
                        <p class="text-gray-400">Rp.{{ $item->price }}</p>
                    </div>
                </button>
                @endforeach
        </main>

        <!-- Sidebar -->
        <aside class="w-full lg:w-1/4 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Items Container</h2>
            <hr class="my-4">
            <div id="items-container" class="mt-4 h-[50vh] overflow-y-auto"></div>

            <div class="form-control mt-4">
                <input type="date" id="sale_date" name="sale_date" class="input input-bordered w-full hidden" value="{{ now()->toDateString() }}" required>
            </div>

            <div class="flex justify-between items-center mt-4">
                <p class="text-gray-700 font-semibold">Total Price :</p>
                <input type="text" id="total_price" name="total_price" class="outline-none bg-transparent text-right font-semibold text-gray-800" readonly>
            </div>
            <hr class="my-4">

            <div class="form-control mb-4">
                <label class="block text-sm font-medium text-gray-700">Payment Method:</label>
                <div class="flex space-x-4">
                    <button type="button" class="btn btn-outline" data-value="Cash" onclick="selectPaymentMethod('Cash', this)">Cash</button>
                    <button type="button" class="btn btn-outline" data-value="E-Wallet" onclick="selectPaymentMethod('E-Wallet', this)">E-Wallet</button>
                    <button type="button" class="btn btn-outline" data-value="Bank" onclick="selectPaymentMethod('Bank', this)">Bank</button>
                </div>
                <input type="hidden" id="payment" name="payment" required>
            </div>

            <!-- Cash Fields -->
            <div id="cash-fields" class="hidden">
                <div class="form-control mb-4">
                    <label for="cash_amount" class="label font-semibold text-gray-700">Nominal Cash:</label>
                    <input type="number" id="cash_amount" class="input input-bordered w-full" min="0" onchange="calculateChange()">
                </div>
                <div class="form-control mb-4">
                    <label for="change_amount" class="label font-semibold text-gray-700">Change:</label>
                    <input type="text" id="change_amount" class="input input-bordered w-full" readonly>
                </div>
            </div>

            <button type="button" class="btn btn-primary w-full mt-4" onclick="toggleModal()">Submit Sale</button>
        </aside>
    </form>

    <!-- Modal for Confirmation -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 max-w-lg">
            <h3 class="text-lg font-bold mb-4">Confirm Sale</h3>
            <div class="mb-4 flex justify-between items-center">
                <p class="font-semibold">Total Price:</p>
                <input type="text" id="modal_total_price" class="outline-none bg-transparent readonly text-right font-semibold">
            </div>
            <div class="mb-4">
                <label for="modal_payment_method" class="label font-semibold">Payment Method:</label>
                <input type="text" id="modal_payment_method" class="outline-none bg-transparent readonly text-right font-semibold">
            </div>
            <div class="mb-4 hidden" id="modal_cash_fields">
                <label for="modal_cash_amount" class="label font-semibold">Nominal Cash:</label>
                <input type="number" id="modal_cash_amount" class="input input-bordered w-full" min="0" readonly>
                <label for="modal_change_amount" class="label font-semibold">Change:</label>
                <input type="text" id="modal_change_amount" class="input input-bordered w-full" readonly>
            </div>
            <div class="flex justify-end">
                <button class="bg-blue-500 text-white p-2 rounded-md" onclick="submitSale()">Confirm</button>
                <button class="bg-gray-500 text-white p-2 rounded-md ml-2" onclick="toggleModal()">Cancel</button>
            </div>
        </div>
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
    let existingItem = $(`#item-${item.id}`);

    if (existingItem.length) {
        // Item already exists, just update the quantity
        let quantityInput = existingItem.find('input[name$="[quantity]"]');
        let newQuantity = parseInt(quantityInput.val()) + 1;
        quantityInput.val(newQuantity);
        updateItemStock(item.id, newQuantity);
    } else {
        // Add new item
        const itemId = `item-${item.id}`;
        const itemDiv = `
            <div class="item mt-2 bg-gray-100 p-4 rounded-lg shadow-sm flex items-center" id="${itemId}">
                <div class="flex items-center w-full">
                    <!-- Image Section -->
                    <div class="flex-shrink-0">
                        <img src="/storage/${item.image}" alt="${item.itemName}" class="w-16 h-16 rounded-md object-cover">
                    </div>

                    <!-- Item Details Section -->
                    <div class="flex-1 ml-4">
                        <div class="flex items-center mb-2">
                            <!-- Quantity Buttons -->
                            <button type="button" class="px-2 py-1 border border-gray-300 bg-gray-200 rounded-l-md" onclick="changeQuantity(${item.id}, -1)">
                                <i class="fa fa-minus text-gray-600">-</i>
                            </button>
                            <input type="text" id="quantity-display-${item.id}" name="items[${itemCount}][quantity]" value="1" class="w-12 text-center border-gray-300 border rounded-md">
                            <button type="button" class="px-2 py-1 border border-gray-300 bg-gray-200 rounded-r-md" onclick="changeQuantity(${item.id}, 1)">
                                <i class="fa fa-plus text-gray-600">+</i>
                            </button>
                        </div>
                        <p class="font-semibold text-gray-800">${item.itemName}</p>
                        <p class="text-gray-600">Price: Rp.${item.price}</p> <!-- Ensure this is being set correctly -->
                    </div>

                    <!-- Hidden Item ID -->
                    <input type="hidden" name="items[${itemCount}][item_id]" value="${item.id}">
                    <input type="hidden" name="items[${itemCount}][price]" value="${item.price}"> <!-- Ensure price is included -->
                </div>
                <button type="button" class="ml-4 text-red-600" onclick="removeItem(${item.id})">
                    <i class="fa fa-trash">Remove</i>
                </button>
            </div>
        `;

        container.append(itemDiv);
        itemCount++;
    }

    updateTotalPrice();
}

        function changeQuantity(itemId, delta) {
            const itemDiv = $(`#item-${itemId}`);
            const quantityInput = itemDiv.find('input[name$="[quantity]"]');
            let newQuantity = parseInt(quantityInput.val()) + delta;

            if (newQuantity <= 0) {
                removeItem(itemId);
            } else {
                quantityInput.val(newQuantity);
                updateItemStock(itemId, newQuantity);
                updateTotalPrice();
            }
        }

        function removeItem(itemId) {
            $(`#item-${itemId}`).remove();
            updateTotalPrice();
        }

        function updateItemStock(itemId, quantity) {
            // Update stock or make an AJAX call if needed
        }

        function updateTotalPrice() {
            let totalPrice = 0;

            $('#items-container .item').each(function() {
                let quantity = $(this).find('input[name$="[quantity]"]').val();
                let price = $(this).find('p.text-gray-600').text().replace('Price: Rp.', '').trim();
                totalPrice += quantity * parseFloat(price);
            });

            $('#total_price').val(totalPrice.toFixed(2));
        }

        function selectPaymentMethod(value, button) {
            $('#payment').val(value);
            $('#modal_payment_method').val(value);

            if (value === 'Cash') {
                $('#cash-fields').removeClass('hidden');
                $('#modal_cash_fields').removeClass('hidden');
            } else {
                $('#cash-fields').addClass('hidden');
                $('#modal_cash_fields').addClass('hidden');
            }
        }

        function calculateChange() {
            let cashAmount = parseFloat($('#cash_amount').val()) || 0;
            let totalPrice = parseFloat($('#total_price').val()) || 0;
            let change = cashAmount - totalPrice;
            $('#change_amount').val(change.toFixed(2));
        }

        function toggleModal() {
    const paymentMethod = $('#payment').val();

    // Cek apakah metode pembayaran sudah dipilih
    if (!paymentMethod) {
        alert('Please select a payment method before proceeding.');
        return;
    }

    // Jika metode pembayaran sudah dipilih, tampilkan modal
    const modal = $('#modal');
    const totalPrice = $('#total_price').val();

    $('#modal_total_price').val(totalPrice);
    $('#modal_payment_method').val(paymentMethod);

    if (paymentMethod === 'Cash') {
        $('#modal_cash_amount').val($('#cash_amount').val());
        $('#modal_change_amount').val($('#change_amount').val());
    } else {
        $('#modal_cash_amount').val('');
        $('#modal_change_amount').val('');
    }

    modal.toggleClass('hidden');
}


function submitSale() {
    $('#isConfirmed').val('true');
    $.ajax({
        url: $('#saleForm').attr('action'),
        type: 'POST',
        data: $('#saleForm').serialize(),
        success: function(response) {
            // Assuming response includes a URL or you can redirect back to a specific route
            window.location.href = "{{ route('sales.creates') }}";
        },
        error: function(xhr) {
            alert('An error occurred while processing the sale.');
        }
    });
}

    </script>
</body>
</html>
@endsection
