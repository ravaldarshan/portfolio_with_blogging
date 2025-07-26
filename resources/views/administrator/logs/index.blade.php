@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Log Systems</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item">Log Systems</div>
        </div>
    @endpush
    @push('section_title')
        Log
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-8">
                        <h4>List Data</h4>
                    </div>
                    <div class="col-4" style="display: flex; justify-content: flex-end;">
                        @if (isallowed('log_system', 'clear'))
                            <a href="javascript:void(0)" class="btn btn-danger clear">
                                <span class="indicator-label-kode">Clear Logs</span>
                                <span class="indicator-progress-kode" style="display: none;">
                                    <div class="d-flex">
                                        <span class="spinner-border spinner-border-sm align-middle ms-2 mt-1"></span>
                                    </div>
                                </span>
                            </a>
                        @endif
                        @if (isallowed('log_system', 'export'))
                            <a href="{{ route('admin.logSystems.generatePDF') }}" target="_blank" class="btn btn-primary mx-3">
                                Export
                            </a>
                        @endif
                        <a href="javascript:void(0)" class="btn btn-primary" id="filterButton">Filter</a>
                    </div>
                </div>
                @include('administrator.logs.filter.main')
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th class="text-center" width="25">
                                        #
                                    </th>
                                    <th width="200">User</th>
                                    <th width="100%">Module</th>
                                    <th width="100%">Action</th>
                                    <th width="200">Tanggal</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('administrator.logs.modal.detail')
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
                    [4, 'desc']
                ],
                scrollX: true, // Enable horizontal scrolling
                ajax: {
                    url: '{{ route('admin.logSystems.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.user = getUser();
                        d.module = getModule();
                    }

                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return '<a href="javascript:void(0)" data-id="' + row.id +
                                '" data-toggle="modal" data-target="#detailLogSystem">' +
                                (meta.row + meta.settings._iDisplayStart + 1) + '</a>';
                        },
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'module',
                        name: 'module'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
            });

            $('#filterButton').on('click', function() {
                $('#filter_section').slideToggle();

            });

            $('#filter_submit').on('click', function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                // Get the filter value using the getUser() function
                var filterUser = getUser();
                var filterModule = getModule();

                // Update the DataTable with the filtered data
                data_table.ajax.url('{{ route('admin.logSystems.getData') }}?user=' + filterUser +
                        '|module=' + filterModule)
                    .load();
            });

            function getUser() {
                return $("#inputUser").val();
            }

            function getModule() {
                return $("#inputModule").val();
            }

            $(document).on('click', '.clear', function(event) {
                const button = $(this);
                const label = button.find('.indicator-label-kode');
                const progress = button.find('.indicator-progress-kode');

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
                        // Menampilkan spinner dan mengganti teks label
                        progress.show();
                        label.text('Clearing data...');

                        $.ajax({
                            type: "GET",
                            url: "{{ route('admin.logSystems.clearLogs') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "GET",
                            },
                            success: function() {
                                // Menyembunyikan spinner dan mengembalikan label
                                progress.hide();
                                label.text('Clear Logs');

                                data_table.ajax.reload(null, false);
                                swalWithBootstrapButtons.fire(
                                    'Berhasil!',
                                    'Data log yang lebih lama dari 7 hari berhasil dihapus.',
                                    'success'
                                );
                            },
                            error: function() {
                                // Menyembunyikan spinner dan mengembalikan label jika terjadi kesalahan
                                progress.hide();
                                label.text('Clear Logs');

                                swalWithBootstrapButtons.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
