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

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
