@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Categories</h4>
                <div>
                    <div class="d-flex">
                        <div class="me-2">
                            <a href="{{ route('categories.file.download') }}"
                                class="btn btn-primary waves-effect waves-light submitBtn">Excel</a>
                            <a href="{{ route('categories.create') }}"
                                class="btn btn-primary waves-effect waves-light submitBtn">Create</a>
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
                    <div>
                        <table id="dataTable" class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">Category</th>
                                    <th class="align-middle">Description</th>
                                    <th class="align-middle">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $item)
                                    {{ Log::info($item) }}
                                    <tr>
                                        <td class="text-capitalize">{{ $item['name'] }} </td>
                                        <td style="text-align: center;">{!! $item['description'] ?? '-' !!}</td>
                                        <td style="width: 150px;">
                                            <a href="{{ route('categories.edit', $item) }}" class="btn btn-sm btn-primary">
                                                Edit </a>
                                            <form action="{{ route('categories.destroy', $item) }}" method="POST"
                                                style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-upload-excel" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Choose Excel </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="min-height: 200px">
                    <form action="{{ route('categories.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input required="required" type="file" name="file" class="form-control mb-3">
                        <button class="btn btn-primary w-100" type="submit">Upload File</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        let dataTable = $("#dataTable");
        $(dataTable).dataTable();
    </script>
@endsection
