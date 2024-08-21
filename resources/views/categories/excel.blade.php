@extends('layouts.modal')

@section('title', 'Choose Excel')

@section('modal-content')
    <form action="{{ route('categories.file.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input required="required" type="file" name="file" class="form-control mb-3">
        <button class="btn btn-primary w-100" type="submit">Upload File</button>
    </form>
@endsection
