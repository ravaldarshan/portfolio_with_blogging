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

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Halaman tidak ditemukan, pastikan url anda dengan benar'))
