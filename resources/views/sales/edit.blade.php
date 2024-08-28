{{-- @extends('layouts.app')

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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sales.update', $sale->id) }}" method="POST" class="themeForm">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="mb-1">Model Number / Part Number</label>
                                <input type="text" class="form-control" placeholder="Model Number / Part Number"
                                    name="model_number" required value="{{ $sale->sku }}">
                            </div>

                            @php
                                $product = $products->first(function ($item) use ($sale) {
                                    return $item->model_number === $sale->sku;
                                });
                            @endphp

                            <div class="col-md-3 mb-3">
                                <label class="mb-1">Product</label>
                                <input type="text" class="form-control" placeholder="Name" name="name" required
                                    readonly value="{{ $product->name }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="mb-1">Warranty Start Date</label>
                                <input type="date" class="form-control startDate" placeholder="Warranty Start Date"
                                    name="startDate" required value="{{ $sale->startDate }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="mb-1">Warranty End Date</label>
                                <input type="date" class="form-control endDate" placeholder="Warranty End Date"
                                    name="endDate" required  value="{{ $sale->endDate }}">
                            </div>


                            <div class="col-md-3 mb-3">
                                    <label class="mb-1">Warranty Start Date</label>
                                    <input type="text" class="form-control startDate" placeholder="Warranty Start Date"
                                        name="sales[0][startDate]" value="{{ $sale->startDate }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="mb-1">Warranty End Date</label>
                                    <input type="text" class="form-control endDate" placeholder="Warranty End Date"
                                        name="sales[0][endDate]" value="{{ $sale->endDate }}">
                                </div>


                            <div class="col-md-12 mb-3">
                                <label class="mb-1">QR Code</label>
                                <input type="text" class="form-control" placeholder="QR Code" name="qr_code" required
                                    value="{{ $sale->qr_code }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="mb-1">Description</label>
                                <textarea class="form-control" placeholder="Description" name="desc" >
                                    {{ $sale->description }}
                                </textarea>
                            </div>

                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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

            // Clear existing options
            $("#product").find(".drop").remove();

            axios.get("{{ route('api.products.categories') }}", {
                params: {
                    'categoryId': $(this).val()
                }
            }).then(function(response) {
                $("#product").empty();
                let res = response.data;
                $.each(res.data, function(index, val) {
                    console.log('VAL: ', val);
                    let zHtml = '<option class="drop" data-sku="' + val.model_number + '" value="' +
                        val.id + '" >' + val.name + '</option>';
                    $("#product").append(zHtml);
                });
            }).catch(function(error) {
                // Handle errors
                console.error('Error fetching products:', error);
            });
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
    <script>
        tinymce.init({
            selector: '#editor'
        });
    </script>
@endsection --}}














@extends('layouts.app')

@section('style')
    <link href="{{ asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="page-title">Sale</h6>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Sales</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="me-2">
                        <a href="{{ route('sales.index') }}"
                            class="btn btn-primary waves-effect waves-light submitBtn">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('sales.update', $sale->id) }}" method="post">
        @csrf
        @method('PUT')
        <div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" id="formContainer">
                            <div class="row formTemplate" style="border-bottom: solid 2px gray; padding: 1rem">
                                <div class="col-md-3 mb-3">

                                {{-- Before user can maybe change the category    let first show the one already in the database for this product   and in the Select Product  --}}
                                    <label class="mb-1">Select Category</label>
                                    <select class="form-control" id="category" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $sale->product && $sale->product->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="mb-1">Select Product</label>
                                    <select class="form-control" id="product" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $sale->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="mb-1">Warranty Start Date</label>
                                    <input type="text" class="form-control startDate" placeholder="Warranty Start Date"
                                        name="startDate" value="{{ $sale->startDate }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="mb-1">Warranty End Date</label>
                                    <input type="text" class="form-control endDate" placeholder="Warranty End Date"
                                        name="endDate" value="{{ $sale->endDate }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Product QR Code</label>
                                    <input type="text" class="form-control qr_code" placeholder="Product QR Code"
                                        name="qr_code" readonly value="{{ $sale->qr_code }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Model Number / Part Number</label>
                                    <input id="sku" type="text" class="form-control sku"
                                        placeholder="Model Number / Part Number" name="sku" value="{{ $sale->sku }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="mb-1">Additional Description</label>
                                    <textarea class="form-control description" placeholder="Description" name="desc" id="description">{{ $sale->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div id="submitContainer" class="col-md-3 mb-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initForm(form) {
                // Initialize date pickers
                const startDatePicker = flatpickr(form.querySelector(".startDate"), {
                    enableTime: false,
                    dateFormat: "Y-m-d",
                    minDate: new Date(),
                    onClose: (selectedDates, dateStr, instance) => {
                        endDatePicker.set('minDate', dateStr);
                    },
                });

                const endDatePicker = flatpickr(form.querySelector(".endDate"), {
                    enableTime: false,
                    dateFormat: "Y-m-d",
                    onClose: (selectedDates, dateStr, instance) => {
                        startDatePicker.set('maxDate', dateStr);
                    },
                });

                // Handle category change
                form.querySelector("#category").addEventListener("change", (e) => {
                    e.preventDefault();
                    const categoryId = e.target.value;
                    const productSelect = form.querySelector("#product");
                    productSelect.innerHTML = '<option value="">Select Product</option>';

                    axios.get("{{ route('api.products.categories') }}", {
                            params: {
                                categoryId: categoryId
                            },
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then((response) => {
                            const products = response.data.data;
                            products.forEach((val) => {
                                const option =
                                    `<option value="${val.id}" data-model="${val.model_number}">${val.name}</option>`;
                                productSelect.insertAdjacentHTML('beforeend', option);
                            });

                            // Re-select the original product if it exists
                            const selectedProduct = form.querySelector('#product').dataset
                                .selectedProduct;
                            if (selectedProduct) {
                                productSelect.value = selectedProduct;
                            }
                        })
                        .catch((error) => {
                            console.error('AJAX error For Getting Products Per Category Selected:',
                                error);
                            alert('An error occurred while fetching products');
                        });
                });

                // Handle product change
                form.querySelector("#product").addEventListener('change', (e) => {
                    e.preventDefault();
                    const selectedOption = e.target.selectedOptions[0];
                    const modelNumber = selectedOption.dataset.model;
                    form.querySelector('#sku').value = modelNumber;
                });

                // Initialize Parsley for validation
                if (typeof $.fn.parsley === 'function') {
                    $(form).parsley({
                        errorClass: 'is-invalid',
                        successClass: 'is-valid',
                        errorsWrapper: '<ul class="parsley-errors-list list-unstyled"></ul>',
                        errorTemplate: '<li class="parsley-error text-danger font-size-10"></li>'
                    });
                } else {
                    alert('Parsley is not available!');
                }
            }

            initForm(document.querySelector('#formContainer'));
        });
    </script>
@endsection
