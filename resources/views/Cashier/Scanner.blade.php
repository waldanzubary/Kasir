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

    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .item-title {
        font-size: 1.25rem; /* Larger text for item name */
        font-weight: 700; /* Bold text */
        color: #2d3748; /* Darker color for contrast */
    }

    .item-price {
        font-size: 1rem;
        color: #4a5568;
    }

    .item-stock {
        font-size: 0.875rem;
        color: #4299e1;
    }
</style>

<body class="bg-gray-100">
    <form id="saleForm" action="{{ route('sales.stores') }}" method="POST" class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4 mr-4">
        @csrf
        <!-- Main Content -->
        <main class="flex-1 bg-white rounded-lg shadow-lg p-6">
            <div class="form-control mt-3 mb-4">
                <input type="text" id="barcode_input" name="barcode" class="input input-bordered w-full bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-300 transition duration-300" placeholder="Scan barcode here">
            </div>
            @if (session('success'))
                <div class="alert alert-success mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                    {{ session('success') }}
                </div>
            @endif

            <input type="hidden" id="isConfirmed" name="isConfirmed" value="false">

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-5 gap-6 fade-up">
                @foreach ($items as $item)
                <button type="button" class="hover-card bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300" onclick="addItem({{ json_encode($item) }})">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->itemName }}" class="w-full h-32 object-cover rounded-t-lg">
                        <span id="status-{{ $item->id }}" class="status absolute top-2 right-2 text-xs font-semibold px-2 py-1 rounded-full"></span>
                    </div>
                    <div class="p-4">
                        <h3 class="item-title truncate">{{ $item->itemName }}</h3>
                        <p class="item-price mt-1">Rp.{{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="item-stock mt-2">Stock: <span class="text-blue-600">{{ $item->stock }}</span></p>
                    </div>
                </button>
                @endforeach
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="w-full lg:w-1/4 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Cart Summary</h2>
            <hr class="my-4 border-gray-200">
            <div id="items-container" class="mt-4 h-[50vh] overflow-y-auto custom-scrollbar pr-2"></div>

            <div class="form-control mt-4">
                <input type="date" id="sale_date" name="sale_date" class="input input-bordered w-full hidden" value="{{ now()->toDateString() }}" required>
            </div>

            <div class="flex justify-between items-center mt-6">
                <p class="text-gray-700 font-semibold">Total Price:</p>
                <input type="text" id="total_price" name="total_price" class="outline-none bg-transparent text-right font-bold text-gray-800 text-lg" readonly>
            </div>
            <hr class="my-4 border-gray-200">

            <div class="form-control mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method:</label>
                <div class="flex grid grid-cols-3 gap-3">
                    <button type="button" class="btn bg-white hover:bg-green-50 transition-colors duration-300" data-value="Cash" onclick="selectPaymentMethod('Cash', this)">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-money-bill-wave text-xl text-green-500 mb-1"></i>
                            <p class="text-xs">Cash</p>
                        </div>
                    </button>
                    <button type="button" class="btn bg-white hover:bg-blue-50 transition-colors duration-300" data-value="E-Wallet" onclick="selectPaymentMethod('E-Wallet', this)">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-wallet text-xl text-blue-500 mb-1"></i>
                            <p class="text-xs">E-Wallet</p>
                        </div>
                    </button>
                    <button type="button" class="btn bg-white hover:bg-yellow-50 transition-colors duration-300" data-value="Bank" onclick="selectPaymentMethod('Bank', this)">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-university text-xl text-yellow-500 mb-1"></i>
                            <p class="text-xs">Bank</p>
                        </div>
                    </button>
                </div>
                <input type="hidden" id="payment" name="payment" required>
            </div>

            <!-- Cash Fields -->
            <div id="cash-fields" class="hidden space-y-4">
                <div class="form-control">
                    <label for="cash_amount" class="label font-semibold text-gray-700">Nominal Cash:</label>
                    <input type="number" id="cash_amount" class="input input-bordered w-full bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-300 transition duration-300" min="0" onchange="calculateChange()">
                </div>
                <div class="form-control">
                    <label for="change_amount" class="label font-semibold text-gray-700">Change:</label>
                    <input type="text" id="change_amount" class="input input-bordered w-full bg-gray-100" readonly>
                </div>
            </div>

            <button type="button" class="btn w-full mt-6 text-white bg-green-500 hover:bg-green-600 transition-colors duration-300" onclick="toggleModal()">Complete Sale</button>
        </aside>
    </form>
        <!-- Modal for Confirmation -->
        <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-8 rounded-lg shadow-xl w-11/12 max-w-md">
                <h3 class="text-2xl font-bold mb-6 text-gray-800">Confirm Sale</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-gray-700">Total Price:</p>
                        <input type="text" id="modal_total_price" class="outline-none bg-transparent text-right font-bold text-gray-800" readonly>
                    </div>
                    <div>
                        <label for="modal_payment_method" class="block font-semibold text-gray-700 mb-1">Payment Method:</label>
                        <input type="text" id="modal_payment_method" class="outline-none bg-transparent text-right font-semibold text-gray-800 w-full" readonly>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button class="btn text-white bg-red-500 hover:bg-red-600 transition-colors duration-300" onclick="toggleModal()">Cancel</button>
                    <button class="btn text-white bg-green-500 hover:bg-green-600 transition-colors duration-300 ml-3" onclick="submitSale()">Confirm</button>
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
