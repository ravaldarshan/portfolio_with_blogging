@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Users</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Users</div>
        </div>
    @endpush
    @push('section_title')
        User
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-8">
                        <h4>List Data</h4>
                    </div>
                    <div class="col-4" style="display: flex; justify-content: flex-end;">
                        @if (isallowed('user', 'add'))
                            <a href="{{ route('admin.users.add') }}" class="btn btn-primary">Add Data</a>
                        @endif
                        @if (isallowed('user', 'archives'))
                            <a href="{{ route('admin.users.archives') }}" class="btn btn-primary mx-3">Archives</a>
                        @endif
                        <a href="javascript:void(0)" class="btn btn-primary" id="filterButton">Filter</a>
                    </div>
                    
                </div>
                @include('administrator.users.filter.main')
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th width="25">No</th>
                                    <th width="200">User Group</th>
                                    <th width="100%">Nama</th>
                                    <th width="200">Email</th>
                                    <th width="100">Status</th>
                                    <th width="200">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('administrator.users.modal.detail')
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
                scrollX: true, 
                ajax: {
                    url: '{{ route('admin.users.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.status = getStatus();
                        d.usergroup = getUserGroup();
                    }

                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'user_group.name',
                        name: 'user_group.name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
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
                    title: 'Are you sure you want to delete this data?',
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
                            url: "{{ route('admin.users.delete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "GET",
                                "id": id,
                            },
                            success: function() {
                                
                                
                                
                                data_table.ajax.reload(null, false);
                                swalWithBootstrapButtons.fire({
                                    title: 'Succeed!',
                                    text: 'Data deleted successfully.',
                                    icon: 'success',
                                    timer: 1500, 
                                    showConfirmButton: false
                                });

                                
                                
                            }
                        });
                    }
                });
            });


            $(document).on('click', '.changeStatus', function(event) {
                var ix = $(this).data('ix');
                if ($(this).is(':checked')) {
                    var status = "Not Active";
                    var changeto = "Active";
                    var message = "";
                } else {
                    var status = "Active"
                    var changeto = "Not Active";
                    var message = "";
                }

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    html: 'Are you sure you want to change the status to ' + changeto + '?' + message,
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Yes, I’m sure!",
                    cancelButtonText: 'No, cancel',
                    reverseButtons: true

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.users.changeStatus') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": "POST",
                                ix: ix,
                                status: changeto,

                            }),
                            success: function() {
                                data_table.ajax.reload(null, false);
                                swalWithBootstrapButtons.fire({
                                    title: 'Succeed!',
                                    text: 'Status berhasil diubah ke ' +
                                        changeto,
                                    icon: 'success',
                                    timer: 1500, 
                                    showConfirmButton: false
                                });
                            }
                        });

                    } else {
                        if (status == "Active") {
                            $(this).prop("checked", true);
                        } else {
                            $(this).prop("checked", false);
                        }
                    }
                });
            });

            $('#filterButton').on('click', function() {
                $('#filter_section').slideToggle();

            });

            var optionUserGroup = $('#filterusergroup');


            optionUserGroup.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Loading...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); 

            $.ajax({
                url: '{{ route('admin.users.getUserGroup') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.usergroup;
                    var optionsHtml = ''; 

                    
                    for (var i = 0; i < data.length; i++) {
                        var userGroup = data[i];
                        optionsHtml += '<option value="' + userGroup.id + '">' + userGroup
                            .name + '</option>';
                    }

                    
                    var finalDropdownHtml = '<option value="">Semua</option>' + optionsHtml;

                    optionUserGroup.html(finalDropdownHtml);

                    loadingSpinner.hide(); 
                },
                error: function() {
                    
                    console.error('Failed memuat data User Group.');
                    optionUserGroup.html('<option>Failed memuat data</option>')
                    loadingSpinner
                        .hide(); 
                }
            });

            $('#filter_submit').on('click', function(event) {
                event.preventDefault(); 

                
                var filterStatus = getStatus();
                var filterUserGroup = getUserGroup();

                
                data_table.ajax.url('{{ route('admin.users.getData') }}?status=' + filterStatus +
                        '|usergroup=' + filterUserGroup)
                    .load();
            });

            function getStatus() {
                return $("#filterstatus").val();
            }

            function getUserGroup() {
                return $("#filterusergroup").val();
            }
        });
    </script>
@endpush
