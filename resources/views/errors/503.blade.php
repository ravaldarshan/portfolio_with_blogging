@php
    $url = request()->url();
@endphp

@if (str_contains($url, '/admin'))
    @php
        $where = 'errors::minimal';
    @endphp
@else
    @php
        $where = 'errors::frontpage';
    @endphp
@endif
@extends($where)

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))
