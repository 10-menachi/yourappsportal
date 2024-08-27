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
                <h6 class="page-title">{{ $category->name }}</h6>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Product Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="me-2">
                        <a href="{{ route('categories.index') }}"
                            class="btn btn-primary waves-effect waves-light submitBtn">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <form id="salesForm" action="{{ route('categories.update', $category->id) }}" method="post">
        @csrf
        @method('PUT')
        <div id="formContainer" class="formContainer">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="mb-1">Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                        required="required" value="{{ $category->name }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="mb-1">Description</label>
                                    <textarea class="form-control" placeholder="Description" name="desc">{{ $category->description }}</textarea>
                                </div>
                            </div>
                            <div id="submitContainer" class="mb-3">
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
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>\
    <script>
        tinymce.init({
            selector: '#editor'
        });
    </script>
@endsection
