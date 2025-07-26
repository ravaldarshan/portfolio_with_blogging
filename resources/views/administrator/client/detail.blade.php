@extends('administrator.layouts.main')

@push('css')
    <style>
        .data_disabled {
            background-color: #aba8a8 !important;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    @push('section_header')
        <h1>Client</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.client') }}">Client</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    @endpush
    @push('section_title')
        Client
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.client.update') }}" method="post" enctype="multipart/form-data" class="form"
                    id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="inputId" value="{{$data->id}}">

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputNama" class="form-label">Nama</label>
                                <input type="text" id="inputNama" class="form-control" placeholder="Masukan Nama" value="{{$data->nama}}"
                                    name="nama" autocomplete="off" data-parsley-required="true" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="inputWebsite" class="form-label">Website</label>
                                <input type="text" id="inputWebsite" class="form-control" placeholder="Masukan Url Website" value="{{$data->website_url}}"
                                    name="website" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="gambarLainnyaInputFile" class="form-label">Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview-image thumbnail mb20">
                                        @if ($data->img_url != '-')
                                        <div class="img-thumbnail-container" id="{{ $data->img_url }}"><img
                                            class="img-thumbnail" width="200"
                                            src="{{ img_src($data->img_url, 'client') }}"><a
                                            class="btn btn-secondary btn-sm data_disabled "
                                            data-img="{{ $data->img_url }}"
                                            data-id="{{ $data->id }}">Hapus</a></div>
                                        @endif
                                    </div>
                                    <div class="mt-3">
                                        <label for="gambarLainnyaInputFile" class="btn btn-light btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <input type="file" class="d-none" id="gambarLainnyaInputFile"
                                                 name="img" disabled>
                                            <!-- Tambahkan atribut "multiple" di sini -->
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('admin.client') }}" class="btn btn-danger me-1 mb-1">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection