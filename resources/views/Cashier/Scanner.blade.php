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
    <form id="saleForm" action="{{ route('sales.stores') }}" method="POST" class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4 p-8">
        @csrf
        <!-- Main Content -->
        <main class="flex-1 bg-white p-6 rounded-lg shadow-md">
            <div class="form-control mb-4">
                <label for="barcode_input" class="label font-semibold text-gray-700">Scan Barcode:</label>
                <input type="text" id="barcode_input" name="barcode" class="input input-bordered w-full" placeholder="Scan barcode here">
            </div>

            <div class="container mx-auto mt-8 bg-white p-4 rounded-lg shadow-md">
                <div class="flex justify-between items-end mb-4">
                    <h1 class="text-2xl font-bold text-gray-800">Create Sale | BARCODE</h1>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary">
                        <i class="fa fa-book"></i> Manual
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <input type="hidden" id="isConfirmed" name="isConfirmed" value="false">

                <h2 class="text-xl font-bold mt-5 text-gray-800">Sales Data</h2>

                <!-- Placeholder for dynamically added items -->

            </div>
        </main>

        <!-- Sidebar -->
        <aside class="w-full lg:w-1/4 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Items Container</h2>
            <hr class="my-4">
            <div id="items-container" class="mt-4 h-[50vh]"></div>

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
            const sidebarContainer = $('#items-container-sidebar');
            let existingItem = $(`#item-${item.id}`);

            if (existingItem.length) {
                // Item already exists, just update the quantity
                let quantityInput = existingItem.find('input[name$="[quantity]"]');
                let newQuantity = parseInt(quantityInput.val()) + 1;
                quantityInput.val(newQuantity);
                updateItemStock(item.id, item.stock);
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
                                    <input type="text" id="quantity-display-${item.id}" name="items[${itemCount}][quantity]" class="bg-transparent w-16 px-2 py-1 text-center border-none outline-none font-semibold flex items-center justify-center" value="1" min="1" max="${item.stock}" readonly>
                                    <button type="button" class="px-2 py-1 border border-gray-300 bg-gray-200 rounded-r-md" onclick="changeQuantity(${item.id}, 1)">
                                        <i class="fa fa-plus text-gray-600">+</i>
                                    </button>
                                </div>

                                <p class="font-semibold text-lg">${item.itemName}</p>
                                <p class="text-gray-600">Price: $${item.price}</p>
                                <input type="hidden" name="items[${itemCount}][item_id]" value="${item.id}">
                                <input type="hidden" name="items[${itemCount}][price]" value="${item.price}">
                            </div>
                        </div>
                    </div>
                `;
                container.append(itemDiv);
                sidebarContainer.append(itemDiv);
                itemCount++;
            }
            calculateTotalPrice();
        }

        function changeQuantity(itemId, delta) {
            let quantityInput = $(`#item-${itemId}`).find('input[name$="[quantity]"]');
            let currentQuantity = parseInt(quantityInput.val());
            let newQuantity = currentQuantity + delta;
            let maxQuantity = parseInt(quantityInput.attr('max'));

            if (newQuantity >= 1 && newQuantity <= maxQuantity) {
                quantityInput.val(newQuantity);
                updateItemStock(itemId, newQuantity);
                calculateTotalPrice();
            }
        }

        function updateItemStock(itemId, quantity) {
            let itemStock = parseInt($(`#item-${itemId}`).find('input[name$="[quantity]"]').attr('max'));
            let remainingStock = itemStock - quantity;
            $(`#item-${itemId}`).find('input[name$="[quantity]"]').attr('max', remainingStock);
        }

        function calculateTotalPrice() {
            let totalPrice = 0;
            $('#items-container').find('.item').each(function() {
                let price = parseFloat($(this).find('input[name$="[price]"]').val());
                let quantity = parseInt($(this).find('input[name$="[quantity]"]').val());
                totalPrice += price * quantity;
            });
            $('#total_price').val(totalPrice.toFixed(2));
            $('#modal_total_price').val(totalPrice.toFixed(2));
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
            let totalPrice = parseFloat($('#total_price').val());
            let cashAmount = parseFloat($('#cash_amount').val());
            let change = cashAmount - totalPrice;
            $('#change_amount').val(change.toFixed(2));
        }

        function toggleModal() {
    let paymentMethod = $('#payment').val();

    if (!paymentMethod) {
        alert('Please select a payment method before submitting.');
        return;
    }

    $('#modal').toggleClass('hidden');
}


        function submitSale() {
            $('#isConfirmed').val('true');
            $('#modal').addClass('hidden');
            $('#saleForm').submit();
        }
    </script>
</body>
</html>

@endsection
