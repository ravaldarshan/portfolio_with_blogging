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

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests'))
