@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Gallery</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Gallery</div>
        </div>
    @endpush
    @push('section_title')
        Gallery
    @endpush

    <div class="row">
        <div class="col-12 col-sm-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12" style="display: flex; justify-content: flex-end;">
                        @if (isallowed('gallery', 'add'))
                            <a href="{{ route('admin.gallery.add') }}" class="btn btn-primary">Tambah Data</a>
                        @endif
                    </div>
                </div>
                <div class="card-body" id="fetchData">
                    <div class="gallery">
                        @foreach ($data as $key => $row)
                            @php
                                $jsonImg = json_decode($row->img_url);
                            @endphp

                            @if (count($jsonImg) > 1)
                                <div class="gallery-item gallery-more"
                                    style="width: 100px !important; height: 100px !important;"
                                    data-image="{{ img_src($jsonImg[0], 'gallery') }}" data-title="{{ $jsonImg[0] }}"
                                    data-id="{{ $row->id }}">
                                    <div
                                        style="
                                display: flex;
                                flex-wrap: wrap;
                                justify-content: center;
                                align-items: center;
                                text-align: center;
                                height: 100%;">
                                        <div style="margin: auto;">+{{ count($jsonImg) }}</div>
                                    </div>
                                </div>


                                @foreach (array_slice($jsonImg, 1) as $col)
                                    <div class="gallery-item gallery-hide" data-image="{{ img_src($col, 'gallery') }}"
                                        data-title="{{ $col }}" data-id="{{ $row->id }}"></div>
                                @endforeach
                            @else
                                <div class="gallery-item" style="width: 100px !important; height: 100px !important;"
                                    data-image="{{ img_src($jsonImg[0], 'gallery') }}" data-title="{{ $jsonImg[0] }}"
                                    data-id="{{ $row->id }}">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('administrator.project.modal.detail') --}}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ template_stisla('modules/chocolat/dist/css/chocolat.css') }}">
@endpush
@push('js')
    <script src="{{ template_stisla('modules/chocolat/dist/js/jquery.chocolat.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.delete', function(event) {
                var id = $(this).data('id');
                var title = $(this).data('title');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin ingin menghapus data ini',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Saya yakin!',
                    cancelButtonText: 'Tidak, Batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('admin.gallery.deleteImage') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "GET",
                                "id": id,
                                "img": title,
                            },
                            success: function() {
                                // data_table.ajax.url(
                                //         '{{ route('admin.project.getData') }}')
                                //     .load();
                                // updateGallery();
                                window.location.reload();
                                swalWithBootstrapButtons.fire({
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success',
                                    timer: 1500, // 2 detik
                                    showConfirmButton: false
                                });

                                // Remove the deleted row from the DataTable without reloading the page
                                // data_table.row($(this).parents('tr')).remove().draw();
                            }
                        });
                    }
                });
            });

            function updateGallery() {
                $.ajax({
                    url: '{{ route('admin.gallery.getGalleryData') }}',
                    success: function(data) {
                        $('#fetchData').html(data);
                    },
                });
            }


        });
    </script>
@endpush
