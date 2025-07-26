@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Komentar Project</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.komentar_project') }}">Komentar Pr</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    @endpush
    @push('section_title')
    {{$data->isi}}
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-8">
                        <h4>List Data</h4>
                    </div>
                    <div class="col-4" style="display: flex; justify-content: flex-end;">
                        
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th width="25">No</th>
                                    <th width="200">User</th>
                                    <th width="200">Project</th>
                                    <th width="100%">Komentar</th>
                                    <th width="200">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    url: '{{ route('admin.komentar_project.detail.getData', $data->id) }}',
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
                        render: function(data, type, row, meta) {
                            if (row.user_id == 0) {
                                return 'Guest';
                            } else {
                                return row.user.nama;
                            }
                        },
                    },
                    {
                        data: 'project.nama',
                        name: 'project.nama'
                    },
                    {
                        data: 'isi',
                        name: 'isi'
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
                            url: "{{ route('admin.komentar_project.detail.delete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "GET",
                                "id": id,
                            },
                            success: function() {
                                // data_table.ajax.url(
                                //         '{{ route('admin.komentar_project.getData') }}')
                                //     .load();
                                data_table.ajax.reload(null, false);
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
        });
    </script>
@endpush
