@extends('Layout.user_dashboard')

@section('title', 'UMKM Warehouse')

@section('content')

<div class="flex sm:justify-end justify-center mb-6 p-3 mt-8 mr-6">
    <a href="Warehouse/create" class="py-3 px-8 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
        <i class="fa-solid fa-plus mr-2 text-lg"></i>
        <span class="text-lg font-semibold">Add More Item</span>
    </a>
</div>

<!-- Container with AOS Animation -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 p-6">
    @foreach ($items as $item)
    <div class="max-w-full mx-auto rounded-lg bg-white overflow-hidden shadow-lg card-hov fade-up transform hover:scale-105 transition-transform duration-300 ease-out">
        <div class="relative p-4">
            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('null.jpg') }}" alt="{{ $item->itemName }}" class="w-full object-cover h-48 rounded-md shadow-md">
            <div class="absolute top-6 left-6">
                <img src="{{ asset('storage/' . $item->barcode) }}" alt="Barcode" class="w-16 rounded-sm shadow-md">
            </div>
            @if($item->stock == 0)
            <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide shadow-lg">OUT OF STOCK</div>
            @else
            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide shadow-lg">IN STOCK</div>
            @endif
        </div>
        <div class="p-5">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-xl font-semibold text-gray-900 truncate">{{ $item->itemName }}</h3>
                <a href="{{ route('warehouse.downloadBarcode', $item->id) }}" class="text-blue-500 hover:text-blue-600 transition-colors duration-300">
                    <i class="fa-solid fa-cloud-arrow-down text-2xl"></i>
                </a>
            </div>
            <p class="text-gray-600 text-sm mb-4">Stock: <span class="font-medium">{{ $item->stock }}</span></p>
            <div class="flex items-center justify-between">
                <span class="font-bold text-lg text-green-600">Rp. {{ number_format($item->price, 0, ',', '.') }}</span>
                <div class="flex gap-2">
                    <a href="/warehouse/{{ $item->id }}/edit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">Edit</a>
                    <form id="delete-form-{{ $item->id }}" action="/warehouse/{{ $item->id }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $item->id }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Logout Modal-->
<div class="modal">
    <div class="modal-box bg-white rounded-lg shadow-xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Ready to Leave?</h2>
        <p class="text-gray-600 mb-6">Select "Logout" below if you are ready to end your current session.</p>
        <div class="modal-action">
            <button class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-md transition-colors duration-300 mr-2" data-dismiss="modal">Cancel</button>
            <a class="btn bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300" href="login.html">Logout</a>
        </div>
    </div>
</div>

<!-- CSS Animations -->
<style>
    .card-hov {
        transition: all 0.3s ease;
    }

    .card-hov:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

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

    /* Typography */
    h3 {
        letter-spacing: -0.5px;
    }

    p {
        letter-spacing: 0.1px;
    }
</style>

<!-- AOS CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#10B981'
            });
        @endif
        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#E74C3C'
            });
        @endif
    });
    
    function confirmDelete(itemId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to delete this item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + itemId).submit();
            }
        });
    }
</script>
@endsection
