@extends('layouts.app')

@section('style')
    <link href="{{ asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="page-title">Edit Sale</h6>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Sales</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </div>
            <div class="col-md-4">
                <div class="d-flex  align-items-center justify-content-end">
                    <div class="me-2">
                        <a href="{{ route('sales.index') }}"
                            class="btn btn-primary waves-effect waves-light submitBtn">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sales.update', $sale->id) }}" method="POST" class="themeForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="mb-1">Category</label>
                                <select id="category" name="categoryId" class="form-control" required>
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $sale['category_id'] ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="mb-1">Product</label>
                                <select id="product" name="productId" class="form-control" required>
                                    <option value="" disabled selected>Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $product->id == $sale['product_id'] ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-3 mb-3">
                                <label class="mb-1">Warranty Start Date</label>
                                <input type="text" class="form-control startDate" placeholder="Warranty Start Date"
                                    name="startDate" required value="{{ $sale['startDate'] }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="mb-1">Warranty End Date</label>
                                <input type="text" class="form-control endDate" placeholder="Warranty End Date"
                                    name="endDate" required value="{{ $sale['endDate'] }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="mb-1">Product Qr Code</label>
                                <input type="text" class="form-control" required placeholder="Product Qr Code"
                                    name="qr_code" value="{{ $sale['qr_code'] }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="mb-1">Additional Description</label>
                                <textarea id="tinymceTextArea" name="description" class="form-control" rows="5">{{ $sale['description'] }}</textarea>
                            </div>

                            <div class="col-md-3 mb-3">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#tinymceTextArea',
            plugins: ['paste', 'lists', 'code', 'table', 'link', 'preview'], //image
            branding: false,
            //menubar: true,
            menubar: 'file edit insert view format table tools help',
            toolbar_sticky: true,
            height: 350,
            paste_as_text: true,
            paste_enable_default_filters: true,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            toolbar: [
                'undo redo | styleselect | bold italic | link | alignleft aligncenter alignright  | code | template | preview'
            ],
        });

        let startpicker = flatpickr(".startDate", {
            enableTime: false,
            dateFormat: "Y-m-d",
            minDate: new Date(),
            onClose: function(selectedDates, dateStr, instance) {
                endpicker.set('minDate', dateStr);
            },
        });

        let endpicker = flatpickr(".endDate", {
            enableTime: false,
            dateFormat: "Y-m-d",
            onClose: function(selectedDates, dateStr, instance) {
                startpicker.set('maxDate', dateStr);
            },
        });

        $("#category").on("change", function(e) {
            e.preventDefault();
            $("#product").find(".drop").remove();
            axiosWithLoader.post("{{ route('api.products.categories') }}", $.param({
                'categoryId': $(this).val()
            })).then(function(response) {
                console.log(response);
                let res = response.data;
                if (res.status === true) {
                    $.each(res.data, function(index, val) {
                        let zHtml = '<option class="drop" data-sku="' + val.sku + '" value="' + val
                            .post_id + '" >' + val.title + '</option>';
                        $("#product").append(zHtml);
                    });
                }
            })
        });

        $("#product").on('change', function(e) {
            e.preventDefault();
            let sku = $(this).find(':selected').attr('sku');
            $("#sku").val(sku);
        })

        $('.themeForm').parsley({
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorsWrapper: '<ul class="parsley-errors-list list-unstyled"></ul>',
            errorTemplate: '<li class="parsley-error text-danger font-size-10"></li>'
        });
    </script>
@endsection
