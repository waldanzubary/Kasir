@extends('Layout.user_dashboard')

@section('content')
<div class="flex align-items-center justify-end mb-2">
    <a href="Warehouse/create" class="btn btn-primary">
        <i class="fa fa-book fa-sm"></i> Create Item
    </a>
</div>

<div class="cards-container">
    @foreach ($items as $item)
    <div class="card">
        <div class="card-header">
            <h2>{{ $item->itemName }}</h2>
        </div>
        <figure>
            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->itemName }}" class="object-cover w-full h-36">
        </figure>
        <div class="card-body">
            <p>Stock: <span class="font-bold">{{ $item->stock }}</span></p>
            <p>Price: Rp. {{ $item->price }}</p>

            @if($item->barcode)
            <div class="mt-2">
                <p>Barcode:</p>
                <img src="{{ asset('storage/' . $item->barcode) }}" alt="Barcode" class="w-16">
                <a href="{{ route('warehouse.downloadBarcode', $item->id) }}" class="btn btn-info btn-xs mt-2">
                    Download Barcode
                </a>
            </div>
            @endif
        </div>

        <div class="card-actions">
            <a href="/warehouse/{{ $item->id }}/edit" class="btn btn-warning btn-xs">Edit</a>
            <form action="/warehouse/{{ $item->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-xs">Delete</button>
            </form>
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

<!-- JavaScript for Dynamic Badge Color -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.badge-status').forEach(function (badge) {
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

<style>
    .cards-container {
        display: flex;
        flex-wrap: wrap;
        margin-top: 25px;
        justify-content: flex-start;
        gap: 20px;
    }

    .card {
        transition: transform 0.2s, box-shadow 0.2s;
        width: 100%;
        max-width: 320px;
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        font-weight: bold;
        border: 1px solid #e2e8f0;
        height: auto; /* Allow auto height based on content */
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .card-header {
        padding: 8px; /* Reduced padding */
        font-weight: bold;
        background: #f7fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .card-body {
        padding: 12px; /* Reduced padding */
        overflow-y: auto;
    }

    .card-body h2 {
        margin: 4px 0; /* Reduced margin for tighter spacing */
        font-size: 16px;
    }

    .card-body p {
        margin: 2px 0; /* Reduced margin for tighter spacing */
        font-size: 14px;
        color: #4a5568;
    }

    .card-actions {
        padding: 8px; /* Reduced padding */
        text-align: right;
        border-top: 1px solid #e2e8f0;
        background: #f7fafc;
    }

    .card-actions a, .card-actions button {
        background-color: #4a5568;
        color: #ffffff;
        padding: 6px 10px; /* Adjusted button padding */
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.2s;
        font-weight: bold;
        font-size: 12px;
        margin-left: 5px;
    }

    .card-actions a:hover, .card-actions button:hover {
        background-color: #2d3748;
    }

    .card-actions .btn-warning {
        background-color: #f6ad55;
    }

    .card-actions .btn-warning:hover {
        background-color: #dd6b20;
    }

    .card-actions .btn-error {
        background-color: #e53e3e;
    }

    .card-actions .btn-error:hover {
        background-color: #c53030;
    }
</style>


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
@endsection
@extends('Layout.user_dashboard')

@section('content')
<!-- Begin Page Content -->
<!-- Page Heading -->
<div class="flex align-items-center justify-end mb-2"> <!-- Reduced bottom margin -->
    <a href="Warehouse/create" class="btn btn-primary">
        <i class="fa fa-book fa-sm"></i> Create Item
    </a>
</div>

<!-- Content Row -->
<div class="cards-container">
    @foreach ($items as $item)
    <div class="card shadow-md transition-transform transform hover:translate-y-1 hover:shadow-lg rounded-lg overflow-hidden w-80 mb-4">
        <figure>
            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->itemName }}" class="object-cover w-full h-36 rounded-t-lg">
        </figure>
        <div class="card-body p-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold">{{ $item->itemName }}</h2>
                <span id="status-{{ $item->id }}" class="badge badge-status text-xs">{{ $item->status }}</span>
            </div>
            <p class="text-gray-400 text-sm">Stock: <span id="stock-{{ $item->id }}" class="font-bold">{{ $item->stock }}</span></p>
            <p class="text-gray-400 text-sm">Price: Rp. {{ $item->price }}</p>
            @if($item->barcode)
            <div class="mt-2">
                <p class="text-gray-400 mb-1 text-xs">Barcode:</p>
                <img src="{{ asset('storage/' . $item->barcode) }}" alt="Barcode" class="w-16">
                <a href="{{ route('warehouse.downloadBarcode', $item->id) }}" class="btn btn-info btn-xs mt-2">Download Barcode</a>
            </div>
            @endif
            <div class="card-actions flex justify-end gap-2 mt-4">
                <a href="/warehouse/{{ $item->id }}/edit" class="btn btn-warning btn-xs text-gray-900">Edit</a>
                <form action="/warehouse/{{ $item->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-xs text-gray-100">Delete</button>
                </form>
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

<!-- JavaScript for Dynamic Badge Color -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.badge-status').forEach(function (badge) {
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
@endsection
