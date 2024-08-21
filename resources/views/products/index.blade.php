@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Products</h4>
                <div>
                    <div class="d-flex">
                        <div class="me-2">
                            <a href="{{ route('products.file.upload') }}" data-toggle="productsModal"
                                class="btn btn-primary">Upload Excel</a>
                            <a href="{{ route('products.file.download') }}"
                                class="btn btn-primary waves-effect waves-light submitBtn">Download Excel</a>
                            <a href="{{ route('products.create') }}"
                                class="btn btn-primary waves-effect waves-light submitBtn">Create</a>
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
                    <table id="dataTable" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle">Category</th>
                                <th class="align-middle">Name</th>
                                <th class="align-middle">Model Number</th>
                                <th class="align-middle">Description</th>
                                <th class="align-middle">Price</th>
                                <th class="align-middle">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->model_number }}</td>
                                    <td style="text-align: center;">{!! $product->description ?? '-' !!}</td>
                                    <td style="text-align: center;">{{ $product->price ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-primary waves-effect waves-light">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger waves-effect waves-light">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('products.excel')
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        let dataTable = $("#dataTable");
        $(dataTable).dataTable();
    </script>
    <script>
        $(document).ready(function() {
            $('a[data-toggle="productsModal"]').on('click', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                $.ajax({
                    url: url,
                    success: function(response) {
                        $('#modalContent').html(response);
                        var modalEl = document.getElementById('productsModal');
                        if (modalEl) {
                            var modalInstance = new bootstrap.Modal(modalEl);
                            modalInstance.show();
                        } else {
                            console.error('Modal element not found');
                        }
                    }
                });
            });
        });
    </script>
@endsection
