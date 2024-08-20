@extends('layouts.app')

@section('style')
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!-- start page title -->
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
                    <a href="{{ route('sales.index') }}" class="btn btn-primary waves-effect waves-light me-2">Back</a>
                    <input type="number" id="duplicateCount" class="form-control me-2" placeholder="Number of Duplicates"
                        min="1">
                    <button class="btn btn-primary waves-effect waves-light" id="duplicateFormBtn">Duplicate</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <form id="salesForm" action="{{ route('sales.create') }}" method="post">
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
                                            <option value="{{ $cat['term_id'] }}">{{ $cat['name'] }}</option>
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
                                    <textarea id="tinymceTextArea" name="sales[0][description]" class="form-control" rows="5"></textarea>
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
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        function initForm(form) {
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

            form.find("#category").on("change", function(e) {
                e.preventDefault();
                let form = $(this).closest('.formTemplate');
                let productSelect = form.find("#product");
                productSelect.empty().append('<option value="">Select Product</option>');
                axios.post("{{ route('api.products.categories') }}", {
                    categoryId: $(this).val()
                }).then(function(response) {
                    let res = response.data;
                    if (res.status) {
                        $.each(res.data, function(index, val) {
                            let option =
                                `<option class="drop" data-sku="${val.sku}" value="${val.post_id}">${val.title}</option>`;
                            productSelect.append(option);
                        });
                    }
                });
            });

            form.find("#product").on('change', function(e) {
                e.preventDefault();
                let sku = $(this).find(':selected').data('sku');
                form.find("#sku").val(sku);
            });

            form.find('.qr-code-input').on('input', function() {
                let qrCodeValue = $(this).val();
                let lastSlashIndex = qrCodeValue.lastIndexOf('/');
                if (lastSlashIndex !== -1) {
                    $(this).val(qrCodeValue.substring(lastSlashIndex + 1));
                }
            });

            form.parsley({
                errorClass: 'is-invalid',
                successClass: 'is-valid',
                errorsWrapper: '<ul class="parsley-errors-list list-unstyled"></ul>',
                errorTemplate: '<li class="parsley-error text-danger font-size-10"></li>'
            });
        }

        $(document).ready(function() {
            initForm($('.formTemplate'));

            $('#duplicateFormBtn').on('click', function(e) {
                e.preventDefault();
                const duplicateCount = parseInt($('#duplicateCount').val());
                const originalForm = $('.formTemplate').first();
                const categorySelect = originalForm.find('#category').val();
                const productSelect = originalForm.find('#product').val();
                const skuValue = originalForm.find('#sku').val();

                if (duplicateCount > 0) {
                    for (let i = 0; i < duplicateCount; i++) {
                        const newForm = originalForm.clone(true).removeClass('formTemplate');
                        newForm.find('#sku').val(skuValue).trigger('input');
                        newForm.find('#product').val(productSelect).trigger(
                        'change'); // Preserve selected product

                        const catSelect = newForm.find('#category');
                        catSelect.val(categorySelect).trigger('change'); // Trigger change to load products

                        // Ensure the QR code field is blank in the new form
                        newForm.find('.qr-code-input').val('').trigger('input');

                        // Update form field names to include the index
                        newForm.find('input, select, textarea').each(function() {
                            let name = $(this).attr('name');
                            $(this).attr('name', name.replace(/\[\d+\]/, `[${i + 1}]`));
                        });

                        // Initialize the cloned form with TinyMCE, flatpickr, etc., just like the original
                        initForm(newForm);

                        // Append the cloned form before the submit container
                        $('#submitContainer').before(newForm);
                    }
                }
            });
        });
    </script>
@endsection
