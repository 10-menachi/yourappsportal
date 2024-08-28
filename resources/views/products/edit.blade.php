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
                <h6 class="page-title">{{ $product->name }}</h6>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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

    <form id="salesForm" action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">

        @csrf
        @method('PUT')
        <div id="formContainer" class="formContainer">
            <div class="row">
                <div class="col-12 align-items-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Category</label>
                                    <select class="form-control" name="category_id" required>
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" required
                                        value="{{ $product->name }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Model Number</label>
                                    <input type="text" class="form-control" placeholder="Model Number"
                                        name="model_number" required value="{{ $product->model_number }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Price</label>
                                    <input type="number" class="form-control" placeholder="Price" name="price"
                                        value="{{ $product->price }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="mb-1">Current Image</label>
                                    <div>
                                        @if ($product->avatar)
                                            <img src="{{ asset('storage/' . $product->avatar) }}"
                                                alt="{{ $product->name }}"
                                                style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                        @else
                                            <p>No image available</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="mb-1">Upload New Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="mb-1">Description</label>
                                    <textarea class="form-control" placeholder="Description" name="desc">{{ $product->description }}</textarea>
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
    <script>
        tinymce.init({
            selector: '#editor'
        });
    </script>
@endsection
