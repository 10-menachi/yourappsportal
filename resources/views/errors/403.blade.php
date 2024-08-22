@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message-1', __($exception->getMessage() ?: 'Forbidden'))
@section('message-2', __('Sorry, you are not authorized to access this page.'))
