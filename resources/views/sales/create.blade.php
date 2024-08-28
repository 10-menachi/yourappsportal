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
        <div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" id="formContainer">
                            <div class="row formTemplate" style="border-bottom: solid 2px gray; padding: 1rem">
                                <div class="col-md-3 mb-3">
                                    <label class="mb-1">Select Category</label>
                                    <select class="form-control category" id="category" name="sales[0][categoryId]" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="mb-1">Select Product</label>
                                    <select class="form-control product" id="product" name="sales[0][productId]" required>
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
                                    <input type="text" class="form-control qr_code" placeholder="Product QR Code"
                                        name="sales[0][qr_code]" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-1">Model Number / Part Number</label>
                                    <input id="sku" type="text" class="form-control sku"
                                        placeholder="Model Number / Part Number" name="sales[0][sku]" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="mb-1">Additional Description</label>
                                    <textarea class="form-control description" placeholder="Description" name="sales[0][description]" id="description"></textarea>
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
        function initForm(form) {
            // Initialize date pickers
            const startDatePicker = flatpickr(form.find(".startDate")[0], {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: new Date(),
                onClose: (selectedDates, dateStr, instance) => {
                    endDatePicker.set('minDate', dateStr);
                },
            });

            const endDatePicker = flatpickr(form.find(".endDate")[0], {
                enableTime: false,
                dateFormat: "Y-m-d",
                onClose: (selectedDates, dateStr, instance) => {
                    startDatePicker.set('maxDate', dateStr);
                },
            });

            // Handle category change
            form.find("#category").on("change", (e) => {
                e.preventDefault();
                const categoryId = $(e.target).val();
                const productSelect = form.find("#product");
                productSelect.empty().append('<option value="">Select Product</option>');

                axios.get("{{ route('api.products.categories') }}", {
                        params: {
                            categoryId: categoryId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then((response) => {
                        const products = response.data.data;
                        $.each(products, (index, val) => {
                            const option =
                                `<option value="${val.id}" data-model="${val.model_number}">${val.name}</option>`;
                            productSelect.append(option);
                        });

                        // Re-select the original product if it exists
                        const selectedProduct = form.find('#product').data('selected-product');
                        if (selectedProduct) {
                            productSelect.val(selectedProduct);
                        }
                    })
                    .catch((error) => {
                        console.error('AJAX error For Getting Products Per Category Selected:', error);
                        alert('An error occurred while fetching products');
                    });
            });

            // Handle product change
            form.find("#product").on('change', (e) => {
                e.preventDefault();
                const selectedOption = $(e.target).find(':selected');
                const modelNumber = selectedOption.data('model');
                form.find('#sku').val(modelNumber);
            });

            // QR code input handling
            form.find('.qr-code-input').on('input', (e) => {
                const qrCodeValue = $(e.target).val();
                const lastSlashIndex = qrCodeValue.lastIndexOf('/');
                if (lastSlashIndex !== -1) {
                    $(e.target).val(qrCodeValue.substring(lastSlashIndex + 1));
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

        $(document).ready(() => {
            initForm($('.formTemplate'));

            $('#duplicateFormBtn').on('click', (e) => {
                e.preventDefault();
                const duplicateCount = parseInt($('#duplicateCount').val(), 10);
                const originalForm = $('.formTemplate').first();
                const originalCategoryId = originalForm.find('.category').val();
                const originalProductId = originalForm.find('.product').val();
                const originalStartDate = originalForm.find('.startDate').val();
                const originalEndDate = originalForm.find('.endDate').val();
                const originalSku = originalForm.find('.sku').val();
                const originalDescription = originalForm.find('.description').val();

                if (duplicateCount > 0) {
                    for (let i = 0; i < duplicateCount; i++) {
                        const newForm = originalForm.clone(true);

                        // Update the name attributes for inputs
                        newForm.find('input, select, textarea').each((index, element) => {
                            const name = $(element).attr('name');
                            $(element).attr('name', name.replace('[0]', '[' + (i + 1) + ']'));
                        });

                         // Set the warranty start and end dates
                        newForm.find('.category').val(originalCategoryId);
                        newForm.find('.product').val(originalProductId);

                        // Set the warranty start and end dates
                        newForm.find('.startDate').val(originalStartDate);
                        newForm.find('.endDate').val(originalEndDate);

                        // Set the model number / part number
                        newForm.find('.sku').val(originalSku);

                        // Set the additional description
                        newForm.find('.description').val(originalDescription);

                        // Add the new form to the form container
                        $('#formContainer').append(newForm);
                        initForm(newForm);
                    }
                }
            });

            $('#salesForm').on('submit', (e) => {
                e.preventDefault();
                if ($(e.target).parsley().isValid()) {
                    $(e.target).off('submit').submit();
                }
            });
        });
    </script>
@endsection
