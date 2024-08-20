@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $product->name }}</h4>
                <div>
                    <div class="d-flex">
                        <div class="me-2">
                            <span class="m-2"></span>
                            {{-- <button data-bs-toggle="modal" data-bs-target=".bs-upload-excel" type="button"
                                class="btn btn-primary waves-effect waves-light submitBtn">Upload Excel</button> --}}

                            <a href="{{ route('products.index') }}"
                                class="btn btn-primary waves-effect waves-light submitBtn">Back</a>
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
                    <div class="text-center">
                        <img src="data:image/png;base64,{{ $qrcode }}" alt="QR Code"
                            style="width: 150px; object-fit: cover">
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
