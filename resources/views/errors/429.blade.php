@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message-1', __('Too Many Requests'))
@section('message-2', __('Sorry, you are making too many requests to our servers.'))
