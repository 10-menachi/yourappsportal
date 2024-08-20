@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sales Product List</h4>
                <div class="#">
                    <form action="{{ route('sales.download') }}" class="m-5" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="createdAt">Sales Date</label>
                                <input type="date" class="form-control" name="createdAt" required>
                            </div>
                            <div class="col-md-6">
                                <label for="productName">Product Name</label>
                                <input type="text" class="form-control" name="productName"
                                    placeholder="Enter product name">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary waves-effect waves-light submitBtn">Download
                                    Sales Data</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div>
                    <div class="d-flex">
                        <div class="me-2">
                            <span class="m-2"></span>
                            {{-- <button data-bs-toggle="modal" data-bs-target=".bs-upload-excel" type="button"
                                class="btn btn-primary waves-effect waves-light submitBtn">Upload Excel</button> --}}

                            <a href="{{ route('sales.create') }}"
                                class="btn btn-primary waves-effect waves-light submitBtn">New Sales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <table id="dataTable" class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sr No.</th>
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">SKU</th>
                                    <th class="align-middle">Sale Date</th>
                                    <th class="align-middle">Warranty End</th>
                                    <th class="align-middle">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-upload-excel" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Choose Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="min-height: 200px">
                    <form action="{{ route('sales.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control mb-3" required>
                        <button class="btn btn-primary w-100" type="submit">Upload File</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        let dataTable = $("#dataTable");
        $(dataTable).dataTable();

        // Initialize toastr (or any other toast library you're using)
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Show a toast notification if there is an error flash message
        @if (session()->get('error'))
            toastr.error("{{ session()->get('error') }}");
        @endif
    </script>
@endsection
