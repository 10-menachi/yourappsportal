@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-sales-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sales</h4>
                <div class="w-50">
                    <form action="{{ route('sales.file.download') }}" class="m-5 text-center" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="createdAt">Date</label>
                                <input type="date" class="form-control" name="createdAt" required>
                            </div>
                            <div class="col-md-6">
                                <label for="productName">Product</label>
                                <select class="form-control" name="product" placeholder="Select a product">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary waves-effect waves-light submitBtn">Download
                                    Excel</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div>
                    <div class="d-flex">
                        <div class="me-2">
                            <!-- Updated to use data-bs attributes for triggering modal -->
                            <a href="{{ route('sales.file.upload') }}" data-bs-toggle="modal" data-bs-target="#salesModal"
                                class="btn btn-primary waves-effect waves-light submitBtn">Upload Excel</a>
                            <a href="{{ route('sales.create') }}"
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
                                <th class="align-middle">Product</th>
                                <th class="align-middle">SKU</th>
                                <th class="align-middle">Warranty Start</th>
                                <th class="align-middle">Warranty End</th>
                                <th class="align-middle">Description</th>
                                <th class="align-middle">Price</th>
                                <th class="align-middle">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td class="text-capitalize">{{ $sale->product->category->name }} <br>
                                        <small>{{ $sale['qr_code'] }}</small>
                                    </td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td>{{ $sale['sku'] }}</td>
                                    <td>{{ $sale['warranty_start_date'] }}</td>
                                    <td>{{ $sale['warranty_end_date'] }}</td>
                                    <td>{!! $sale['description'] !!}</td>
                                    <td>{{ $sale->product->price ?? '-' }}</td>
                                    <td style="width: 150px">
                                        <a href="{{ route('sales.edit', $sale->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <a href="{{ route('sales.show', $sale->id) }}"
                                            class="btn btn-sm btn-success">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('sales.excel')
@endsection

@section('script')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#dataTable").dataTable();

            $('a[data-bs-toggle="salesModal"]').on('click', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                $.ajax({
                    url: url,
                    success: function(response) {
                        var modalEl = document.getElementById('salesModal');
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
