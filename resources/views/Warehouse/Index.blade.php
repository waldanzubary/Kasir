@extends('Layout.user_dashboard')

@section('content')
<div class="flex sm:justify-start justify-center mb-1 p-3 mt-4 ml-6">
    <a href="Warehouse/create" class="py-3 px-8 bg-gradient-to-r bg-green-500 hover:bg-green-600 text-white rounded-lg shadow-lg ">
        <i class="fa-solid fa-plus mr-2 text-lg"></i>
        <span class="text-lg font-semibold">Add More Item</span>
    </a>
</div>

<!-- Container with AOS Animation -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-2 p-3">
    @foreach ($items as $item)
    <div class="max-w-full mx-auto rounded-md bg-white overflow-hidden shadow-md card-hov fade-up">
        <div class="relative p-3">
            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('null.jpg') }}" alt="{{ $item->itemName }}" class="w-64 object-cover h-48">
            <div class="">
                <img src="{{ asset('storage/' . $item->barcode) }}" alt="Barcode" class="w-16 absolute top-0 m-5 left-0">
            </div>
            @if($item->stock == 0)
            <div class="absolute top-0 right-0 bg-red-500 text-white px-2 py-1 m-5 rounded-md text-sm font-medium">OUT STOCK</div>
            @else
            <div class="absolute top-0 right-0 bg-green-500 text-white px-2 py-1 m-5 rounded-md text-sm font-medium">IN STOCK</div>
            @endif
        </div>
        <div class="p-4">
            <div class="flex justify-between">
                <h3 class="text-lg font-medium mb-2">{{ $item->itemName }}</h3>
                <a href="{{ route('warehouse.downloadBarcode', $item->id) }}" class=""><i class="fa-solid text-2xl fa-cloud-arrow-down" style="color: #74C0FC;"></i></a>
            </div>
            <p class="text-gray-600 text-sm mb-4">Stock : {{ $item->stock }}</p>
            <div class="flex items-center justify-between">
                <span class="font-bold text-sm">Rp. {{ $item->price }}</span>
                <div class="flex gap-2">
                    <a href="/warehouse/{{ $item->id }}/edit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Edit</a>
                    <form action="/warehouse/{{ $item->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal">
    <div class="modal-box">
        <h2 class="text-lg font-bold">Ready to Leave?</h2>
        <p>Select "Logout" below if you are ready to end your current session.</p>
        <div class="modal-action">
            <button class="btn" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
    </div>
</div>

<!-- CSS Animations -->
<style>
    .card-hov {
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    }

    .card-hov:hover {
        background-color: rgb(248, 248, 248);
        transform: translateY(-5px); /* Moves the card up slightly */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds a shadow effect */
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

<!-- Page level plugins -->
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
<script src="{{ asset('js/book.js') }}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "Item created successfully!",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Initialize AOS animations
        AOS.init();
    });
</script>
@endsection
