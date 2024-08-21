@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Categories</h4>
                <div>
                    <div class="d-flex">
                        <div class="me-2">
                            <a href="{{ route('categories.file.upload') }}" data-toggle="modal" class="btn btn-primary">Upload
                                Excel</a>
                            <a href="{{ route('categories.file.download') }}"
                                class="btn btn-primary waves-effect waves-light submitBtn">Download Excel</a>
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
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        let dataTable = $("#dataTable");
        $(dataTable).dataTable();
    </script>
@endsection
