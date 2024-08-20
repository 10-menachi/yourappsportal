@extends('layouts.app')

@section('style')
    <!-- Include flatpickr CSS -->
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!-- Start Page Title -->
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="page-title">Create Product</h6>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="me-2">
                        <a href="{{ route('products.index') }}"
                            class="btn btn-primary waves-effect waves-light submitBtn">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <form id="salesForm" action="{{ route('products.store') }}" method="post">
        @csrf
        <div id="formContainer" class="formContainer">
            <div class="row">
                <div class="col-12 align-items-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Category</label>
                                    <select class="form-control" name="category_id" required="required">
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Model Number</label>
                                    <input type="text" class="form-control" placeholder="Model Number"
                                        name="model_number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">QR Code</label>
                                    <input type="text" class="form-control" placeholder="QR Code" name="qr_code"
                                        required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Description</label>
                                    <input type="text" class="form-control" placeholder="Description" name="desc">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Price</label>
                                    <input type="number" class="form-control" placeholder="Price" name="price">
                                </div>
                            </div>
                            <div id="submitContainer" class="col-md-12 mb-3">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <!-- Include JavaScript files -->
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
@endsection
