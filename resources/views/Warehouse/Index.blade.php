@extends('Layout.Layout')
@section('content')
<!-- Begin Page Content -->
    <style>
        .fav {
    /* position: absolute; */
    /* margin-left: 40px;
    top: 150px; */
    width: 20px;
    height: 20px;
}

.fav input {
    display: none;
}

.fav label{
    width: 100%;
    height: 100%;
    display: block;
    background-image: url('/sb-my-admin/img/heart.png');
    background-size: cover  ;
}
.fav input:checked + label {
    background-image: url('/sb-my-admin/img/heartFill.png');
}
    </style>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">WareHouse</h1>

        <div class="d-sm-flex align-items-center justify-content-between">
        <a href="managebuku" class="d-none d-sm-inline-block btn btn-sm   shadow-sm" style="background-color: rgba(116, 101, 194, 1); color:white">
            <i class="fa fa-book fa-sm text-white-50"></i> Manage Item
        </a>
        <a href="book-add" class="d-none d-sm-inline-block btn btn-sm  ml-3 shadow-sm"  style="background-color: rgba(116, 101, 194, 1); color:white">
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
                    <p>stock : "{{ $item ->stock }}</p>
                    <p>harga : "{{ $item ->price }}</p>
                </div>
                <!-- Card Body -->
                <a href="/buku/{{ $item->id }}" class="card-body">
                    <div style="width: 100%; height: 300px" class="cover">
                        <img style="width: 100%; height: 100%" src="{{ $item->image }}">
                    </div>
                </a>
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
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>
<script src="{{ asset('js/book.js') }}"></script>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var books = @json($books);
        books.forEach(book => {
            var dataVisibility = localStorage.getItem('DataVisibility_' + book.id);
            if (dataVisibility === 'true') {
                fetchDataAndDisplay(book.id);
            }
        });
    });

    function toggleDataVisibility(bookId) {
        var checkbox = document.getElementById('ShowDataCheckBox_' + bookId);
        var dataContainer = document.getElementById('dataContainer_' + bookId);

        localStorage.setItem('DataVisibility_' + bookId, checkbox.checked);

        if (checkbox.checked) {
            fetchDataAndDisplay(bookId);
        } else {
            dataContainer.style.display = 'none';
        }
    }

    function fetchDataAndDisplay(bookId) {
        fetch('/api/books/' + bookId)
            .then(response => response.json())
            .then(book => {
                var dataContainer = document.getElementById('dataContainer_' + bookId);
                dataContainer.innerHTML = '';

                var html = `
                    <div class="col-xl-3">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">${book.title}</h6>
                                <input onchange="toggleDataVisibility(${book.id})" type="checkbox" id="ShowDataCheckBox_${book.id}" value="${book.id}" ${localStorage.getItem('DataVisibility_' + book.id) === 'true' ? 'checked' : ''}>
                                <label for="ShowDataCheckBox_${book.id}"></label>
                            </div>
                            <a href="/buku/${book.id}" class="card-body">
                                <div style="width: 100%; height: 300px" class="cover">
                                    <img style="width: 100%; height: 100%" src="${book.cover}">
                                </div>
                            </a>
                        </div>
                    </div>`;
                dataContainer.innerHTML += html;

                dataContainer.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    window.onload = function() {
        var checkboxes = document.querySelectorAll('[id^="ShowDataCheckBox_"]');
        checkboxes.forEach(function(checkbox) {
            var bookId = checkbox.value;
            var dataVisibility = localStorage.getItem('DataVisibility_' + bookId);

            if (dataVisibility === 'true') {
                checkbox.checked = true;
                fetchDataAndDisplay(bookId);
            } else {
                checkbox.checked = false;
            }
        });
    }
</script> --}}
@endsection
