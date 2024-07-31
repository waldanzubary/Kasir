@extends('Layout.Layout')

@section('content')
<!-- Begin Page Content -->
<style>
    .fav {
        width: 20px;
        height: 20px;
    }

    .fav input {
        display: none;
    }

    .fav label {
        width: 100%;
        height: 100%;
        display: block;
        background-image: url('/sb-my-admin/img/heart.png');
        background-size: cover;
    }

    .fav input:checked + label {
        background-image: url('/sb-my-admin/img/heartFill.png');
    }
</style>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">WareHouse</h1>

    <div class="d-sm-flex align-items-center justify-content-between">
        <a href="Warehouse/create" class="d-none d-sm-inline-block btn btn-sm ml-3 shadow-sm" style="background-color: rgba(116, 101, 194, 1); color:white">
            <i class="fa fa-book fa-sm text-white-50"></i> Create Item
        </a>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    @foreach ($Item as $item)
    <div class="col-xl-3">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">{{ $item->itemName }}</h6>
                <p>Stock: {{ $item->stock }}</p>
                <p>Price: RP. {{ $item->price }}</p>
            </div>
            <!-- Card Body -->
            <a href="/buku/{{ $item->id }}" class="card-body">
                <div style="width: 100%; height: 300px" class="cover">
                    <img style="width: 100%; height: 100%" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->itemName }}">
                </div>
            </a>
            <!-- Card Footer -->
            <div class="card-footer d-flex justify-content-between">
                <a href="/warehouse/{{ $item->id }}/edit" class="btn btn-warning btn-sm">
                    Edit
                </a>
                <form action="/warehouse/{{ $item->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    <div id="dataContainer"></div>
</div>

<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

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
