@extends('Layout.user_dashboard')

@section('title', 'UMKM Cashier')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Create Sale</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daisyui@2.26.1/dist/full.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
    @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.6s ease-out;
        }

</style>
<body>
    <form id="saleForm" action="{{ route('sales.stores') }}" method="POST" class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4 mr-4">
        @csrf
        <!-- Main Content -->
        <main class="flex-1   ">
            <div class="form-control  mt-3 mb-2">

                <input type="text" id="barcode_input" name="barcode" class="input input-bordered w-full" placeholder="Scan barcode here">
            </div>
                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <input type="hidden" id="isConfirmed" name="isConfirmed" value="false">

                <div class="flex justify-center">

            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-5 gap-2 fade-up">
                @foreach ($items as $item)
                <button type="button" class="shadow-lg rounded-lg bg-white w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg overflow-hidden mt-2 hover-card transform transition-transform duration-300 ease-in-out hover:scale-105" onclick="addItem({{ json_encode($item) }})">
                    <div class="relative">
                        <div class="flex p-2 absolute top-0 left-0">
                            <span id="status-{{ $item->id }}" class="status bg-gray-200 text-white rounded p-1 text-xs font-semibold">{{ $item->status }}</span>
                        </div>
                        <figure>
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->itemName }}" class="object-cover w-full h-44 rounded-t-lg">
                        </figure>
                    </div>
                    <div class="card-body p-4">
                        <div class="flex flex-col h-full justify-between">
                            <div>
                                <p class="text-sm text-black font-semibold text-left break-words">{{ $item->itemName }}</p>
                                <p class="text-xs text-neutral-400 font-semibold text-left mt-1 break-words">Rp.{{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <!-- Display stock information -->
                            <div class="mt-2">
                                <p class="text-xs text-red-500 font-semibold text-left">Stock: {{ $item->stock }}</p>
                            </div>
                        </div>
                    </div>
                </button>
            @endforeach
            </div>





        </main>

        <!-- Sidebar -->
        <aside class="w-full lg:w-1/4 bg-white p-6 rounded-lg shadow-md ">
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

            <div class="form-control mb-4 ">
                <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method:</label>
                <div class="flex grid grid-cols-3 gap-3">
                    <button type="button" class="btn w-17 h-14" data-value="Cash" onclick="selectPaymentMethod('Cash', this)">
                        <div class="flex flex-col"><i class="fa-solid fa-money-bill-1-wave text-xl" style="color: #63E6BE;"></i><p class="text-xs">Cash</p></div>
                    </button>
                    <button type="button" class="btn w-17 h-14" data-value="E-Wallet" onclick="selectPaymentMethod('E-Wallet', this)">
                        <div class="flex flex-col"><i class="fa-solid fa-wallet text-xl" style="color: #74C0FC;"></i><p class="text-xs">E-Wallet</p></div>
                    </button>
                    <button type="button" class="btn w-17 h-14" data-value="Bank" onclick="selectPaymentMethod('Bank', this)">
                        <div class="flex flex-col"><i class="fa-solid fa-landmark text-xl" style="color: #FFD43B;"></i><p class="text-xs">Bank</p></div>
                    </button>
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

            <button type="button" class=" btn w-full mt-4 text-white bg-green-500"  onclick="toggleModal()">Submit Sale</button>
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
           <div class="item mt-4 p-4 bg-gray-100 rounded-lg shadow-lg" id="${itemId}">
    <div class="flex items-start space-x-4 w-full">
        <!-- Image Section -->
        <img src="/storage/${item.image}" alt="${item.itemName}" class="w-24 h-24 rounded-md object-cover shadow-md">

        <!-- Item Details Section -->
        <div class="flex-1">

            <p class="font-semibold text-gray-800 text-sm">${item.itemName}</p>
            <p class="text-gray-600 mt-1 mb-2 text-sm">Rp.${item.price}</p>

            <div class="flex items-center mb-4 ">
                <!-- Quantity Buttons -->
                <button type="button" class="  rounded-lg  " onclick="changeQuantity(${item.id}, -1)">
                    <i class="text-lg text--rose-600 font-bold">-</i>
                </button>
                <input type="text" id="quantity-display-${item.id}" name="items[${itemCount}][quantity]" value="1" class="w-16 bg-transparent text-center  outline-none">
                <button type="button" class=" " onclick="changeQuantity(${item.id}, 1)">
                    <i class="text-lg text-green-600 font-bold">+</i>
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Item ID -->
    <input type="hidden" name="items[${itemCount}][item_id]" value="${item.id}">
    <input type="hidden" name="items[${itemCount}][price]" value="${item.price}">
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
                let price = $(this).find('p.text-gray-600').text().replace('Rp.', '').trim();
                totalPrice += quantity * parseFloat(price);
            });

            $('#total_price').val(totalPrice.toFixed(2));
        }

        function selectPaymentMethod(value, button) {
            $('#payment').val(value);
            $('#modal_payment_method').val(value);

            $('.btn').removeClass('bg-green-200');
            $(button).addClass('bg-green-200');


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


document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.status').forEach(function (badge) {
            if (badge.textContent.trim() === 'outStock') {
                badge.classList.add('bg-red-500', 'text-white');
                badge.classList.remove('bg-green-500');
            } else {
                badge.classList.add('bg-green-500', 'text-white');
                badge.classList.remove('bg-red-500');
            }
        });
    });

    </script>
</body>
</html>
@endsection
