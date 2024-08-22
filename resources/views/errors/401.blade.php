@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message-1', __('Unauthorized'))
@section('message-2', __('Sorry, you are not authorized to access this page.'))
