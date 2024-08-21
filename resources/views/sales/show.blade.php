@extends('layouts.app')

@section('content')
    {{ Log::info($sale) }}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $sale->name }}</h4>
                <div>
                    <div class="d-flex">
                        <div class="me-2">
                            <span class="m-2"></span>
                            <a href="{{ route('sales.index') }}"
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
                    <div class="row my-3">
                        <div class="col-md-4 mb-3">
                            <div class="mb-1 fw-bold">Category</div>
                            <div class="form-control" required>{{ $sale->category->name }}</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="mb-1 fw-bold">Product</div>
                            <div class="form-control" required>{{ $sale->product->name }}</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="mb-1 fw-bold">Warranty Start</div>
                            <div class="form-control" required>{{ $sale->warranty_start_date }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="mb-1 fw-bold">Warranty End</div>
                            <div class="form-control" required>{{ $sale->warranty_end_date }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="mb-1 fw-bold">SKU</div>
                            <div class="form-control" required>{{ $sale->sku }}</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="mb-1 fw-bold">Description</div>
                            <div class="form-control" required>
                                {!! $sale['description'] ?? '-' !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
