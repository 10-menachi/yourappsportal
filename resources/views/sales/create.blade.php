@extends('layouts.app')

@section('style')
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('path/to/parsley.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="page-title">Sale</h6>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Sales</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="me-2">
                        <a href="{{ route('sales.index') }}"
                            class="btn btn-primary waves-effect waves-light submitBtn">Back</a>
                    </div>
                    <div class="me-2">
                        <input type="number" id="duplicateCount" class="form-control" placeholder="Number of Duplicates"
                            min="1">
                    </div>
                    <div>
                        <button class="btn btn-primary waves-effect waves-light" id="duplicateFormBtn">Duplicate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="salesForm" action="{{ route('sales.store') }}" method="post">
        @csrf
        <div id="formContainer">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row formTemplate">
                                <div class="col-md-3 mb-3">
                                    <label class="mb-1">Select Category</label>
                                    <select class="form-control" id="category" name="sales[0][categoryId]" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="mb-1">Select Product</label>
                                    <select class="form-control" id="product" name="sales[0][productId]" required>
                                        <option value="">Select Product</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="mb-1">Warranty Start Date</label>
                                    <input type="text" class="form-control startDate" placeholder="Warranty Start Date"
                                        name="sales[0][startDate]" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="mb-1">Warranty End Date</label>
                                    <input type="text" class="form-control endDate" placeholder="Warranty End Date"
                                        name="sales[0][endDate]" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Product QR Code</label>
                                    <input type="text" class="form-control qr-code-input" placeholder="Product QR Code"
                                        name="sales[0][qr_code]" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Model Number / Part Number</label>
                                    <input id="sku" type="text" class="form-control"
                                        placeholder="Model Number / Part Number" name="sales[0][sku]" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="mb-1">Additional Description</label>
                                    <textarea class="form-control" placeholder="Description" name="sales[0][description]" id="description"></textarea>
                                </div>
                            </div>
                            <div id="submitContainer" class="col-md-3 mb-3">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        function initForm(form) {
            // Initialize TinyMCE editor
            tinymce.init({
                selector: form.find('#tinymceTextArea')[0],
                plugins: ['paste', 'lists', 'code', 'table', 'link', 'preview'],
                branding: false,
                menubar: 'file edit insert view format table tools help',
                toolbar_sticky: true,
                height: 350,
                paste_as_text: true,
                paste_enable_default_filters: true,
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
                toolbar: 'undo redo | styleselect | bold italic | link | alignleft aligncenter alignright | code | template | preview',
            });

            // Initialize date pickers
            let startpicker = flatpickr(form.find(".startDate")[0], {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: new Date(),
                onClose: function(selectedDates, dateStr, instance) {
                    endpicker.set('minDate', dateStr);
                },
            });

            let endpicker = flatpickr(form.find(".endDate")[0], {
                enableTime: false,
                dateFormat: "Y-m-d",
                onClose: function(selectedDates, dateStr, instance) {
                    startpicker.set('maxDate', dateStr);
                },
            });

            // Handle category change
            form.find("#category").on("change", function(e) {
                e.preventDefault();
                let form = $(this).closest('.formTemplate');
                let productSelect = form.find("#product");
                productSelect.empty().append('<option value="">Select Product</option>');
                axios.get("{{ route('api.products.categories') }}", {
                    params: {
                        categoryId: $(this).val()
                    }
                }).then(function(response) {
                    let products = response.data.data;
                    $.each(products, function(index, val) {
                        let option =
                            `<option class="drop" value="${val.id}" data-model="${val.model_number}">${val.name}</option>`;
                        productSelect.append(option);
                    });
                }).catch(function(error) {
                    alert('An error occurred while fetching products');
                });
                $('.formTemplate').find('#category').val($(this).val());
            });

            // Handle product change
            form.find("#product").on('change', function(e) {
                e.preventDefault();
                let selectedOption = $(this).find(':selected');
                let modelNumber = selectedOption.data('model');
                $('.formTemplate').find('#sku').val(modelNumber);
                $('.formTemplate').find('#product').val($(this).val());
            });

            // handle warranty start date change
            form.find('.startDate').on('change', function() {
                $('.formTemplate').find('.startDate').val($(this).val());
            });

            // handle warranty end date change
            form.find('.endDate').on('change', function() {
                $('.formTemplate').find('.endDate').val($(this).val());
            });

            // handle description change
            form.find('#description').on('change', function() {
                $('.formTemplate').find('#description').val($(this).val());
            });

            // QR code input handling
            form.find('.qr-code-input').on('input', function() {
                let qrCodeValue = $(this).val();
                let lastSlashIndex = qrCodeValue.lastIndexOf('/');
                if (lastSlashIndex !== -1) {
                    $(this).val(qrCodeValue.substring(lastSlashIndex + 1));
                }
            });

            // Initialize Parsley for validation
            if (typeof $.fn.parsley === 'function') {
                form.parsley({
                    errorClass: 'is-invalid',
                    successClass: 'is-valid',
                    errorsWrapper: '<ul class="parsley-errors-list list-unstyled"></ul>',
                    errorTemplate: '<li class="parsley-error text-danger font-size-10"></li>'
                });
            } else {
                alert('Parsley is not available!');
            }
        }

        $(document).ready(function() {
            initForm($('.formTemplate'));

            $('#duplicateFormBtn').on('click', function(e) {
                e.preventDefault();
                const duplicateCount = parseInt($('#duplicateCount').val(), 10);
                const originalForm = $('.formTemplate').first();

                if (duplicateCount > 0) {
                    for (let i = 0; i < duplicateCount; i++) {
                        const newForm = originalForm.clone(true);
                        newForm.find('input, select, textarea').each(function() {
                            const name = $(this).attr('name');
                            $(this).attr('name', name.replace('[0]', '[' + (i + 1) + ']'));
                        });
                        newForm.find('#category').val(originalForm.find('#category').val());
                        newForm.find('#product').val(originalForm.find('#product').val());
                        newForm.find('#warrantyStartDate').val(originalForm.find('#warrantyStartDate')
                        .val());
                        newForm.find('#warrantyEndDate').val(originalForm.find('#warrantyEndDate').val());
                        newForm.find('#sku').val(originalForm.find('#sku').val());
                        newForm.find('#description').val(originalForm.find('#description').val());
                        $('#formContainer').append(newForm);
                        initForm(newForm);
                    }
                }
            });

            $('#salesForm').on('submit', function(e) {
                e.preventDefault();
                if ($(this).parsley().isValid()) {
                    $(this).off('submit').submit();
                }
            });
        });
    </script>
@endsection
