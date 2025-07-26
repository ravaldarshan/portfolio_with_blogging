@extends('administrator.layouts.main')

@section('content')
@push('section_header')
        <h1>Kategori Project</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.kategori_project') }}">Kategori Project</a></div>
            <div class="breadcrumb-item">Arsip</div>
        </div>
    @endpush
    @push('section_title')
        Kategori Project
    @endpush
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-8">
                    <h4>List Data</h4>
                </div>
                <div class="col-4" style="display: flex; justify-content: flex-end;">
                    <a href="{{route('admin.kategori_project')}}" class="btn btn-primary mx-3">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th width="25">No</th>
                                <th width="100%">Nama</th>
                                <th width="100%">Slug</th>
                                <th width="200">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('administrator.kategori_project.modal.detail')
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        var data_table = $('#datatable').DataTable({
            "oLanguage": {
                "oPaginate": {
                    "sFirst": "<i class='ti-angle-left'></i>",
                    "sPrevious": "&#8592;",
                    "sNext": "&#8594;",
                    "sLast": "<i class='ti-angle-right'></i>"
                }
            },
            processing: true,
            serverSide: true,
            order: [
                [0, 'asc']
            ],
            scrollX: true, // Enable horizontal scrolling
            ajax: {
                url: '{{ route('admin.kategori_project.getDataArsip') }}',
                dataType: "JSON",
                type: "GET",
                data: function(d) {
                }

            },
            columns: [{
                render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    sortable: false,
                    class: 'text-center'
                }
            ],
        });


        $(document).on('click', '.delete', function(event) {
            var id = $(this).data('id');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-4',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin ingin menghapus data ini secara permanent',
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
                        url: "{{ route('admin.kategori_project.forceDelete') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "GET",
                            "id": id,
                        },
                        success: function() {
                            // data_table.ajax.url(
                            //         '{{ route('admin.kategori_project.getData') }}')
                            //     .load();
                            data_table.ajax.reload(null, false);
                            swalWithBootstrapButtons.fire(
                                'Berhasil!',
                                'Data berhasil dihapus secara permanent.',
                                'success'
                            );

                            // Remove the deleted row from the DataTable without reloading the page
                            // data_table.row($(this).parents('tr')).remove().draw();
                        }
                    });
                }
            });
        });

        $(document).on('click', '.restore', function(event) {
            var id = $(this).data('id');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-4',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin ingin memulihkan data ini',
                icon: 'warning',
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Ya, Saya yakin!',
                cancelButtonText: 'Tidak, Batalkan!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('admin.kategori_project.restore') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "PUT",
                            "id": id,
                        },
                        success: function() {
                            // data_table.ajax.url(
                            //         '{{ route('admin.kategori_project.getData') }}')
                            //     .load();
                            data_table.ajax.reload(null, false);
                            swalWithBootstrapButtons.fire(
                                'Berhasil!',
                                'Data berhasil dipulihkan.',
                                'success'
                            );

                            // Remove the PUT row from the DataTable without reloading the page
                            // data_table.row($(this).parents('tr')).remove().draw();
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
