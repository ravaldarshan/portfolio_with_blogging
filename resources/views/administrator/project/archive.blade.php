@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Project</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.project') }}">Project</a></div>
            <div class="breadcrumb-item">Archives</div>
        </div>
    @endpush
    @push('section_title')
        Project
    @endpush
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-8">
                        <h4>List Data</h4>
                    </div>
                    <div class="col-4" style="display: flex; justify-content: flex-end;">
                        <a href="{{ route('admin.project') }}" class="btn btn-primary mx-3">Return</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th width="25">No</th>
                                    <th width="300">Nama</th>
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
                    url: '{{ route('admin.project.getDataArchives') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {}

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
                    title: 'Are you sure you want to delete this data? secara permanent',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, I am sure!',
                    cancelButtonText: 'No, Cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('admin.project.forceDelete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "GET",
                                "id": id,
                            },
                            success: function() {
                                // data_table.ajax.url(
                                //         '{{ route('admin.project.getData') }}')
                                //     .load();
                                data_table.ajax.reload(null, false);
                                swalWithBootstrapButtons.fire({
                                    title: 'Succeed!',
                                    text: 'Data has been successfully deleted permanently.',
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
                    title: 'Are you sure you want to recover this data?',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, I am sure!',
                    cancelButtonText: 'No, Cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('admin.project.restore') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "PUT",
                                "id": id,
                            },
                            success: function() {
                                // data_table.ajax.url(
                                //         '{{ route('admin.project.getData') }}')
                                //     .load();
                                data_table.ajax.reload(null, false);
                                swalWithBootstrapButtons.fire({
                                    title: 'Succeed!',
                                    text: 'Data berhasil dipulihkan.',
                                    icon: 'success',
                                    timer: 1500, // 2 detik
                                    showConfirmButton: false
                                });

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
