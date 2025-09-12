@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Blog</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Blog</div>
        </div>
    @endpush
    @push('section_title')
    Blog
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-8">
                        <h4>List Data</h4>
                    </div>
                    <div class="col-4" style="display: flex; justify-content: flex-end;">
                        @if (isallowed('blog', 'add'))
                            <a href="{{ route('admin.blog.add') }}" class="btn btn-primary">Add Data</a>
                        @endif
                        @if (isallowed('blog', 'archives'))
                            <a href="{{ route('admin.blog.archives') }}" class="btn btn-primary mx-3">Archives</a>
                        @endif
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th width="25">No</th>
                                    <th width="200">Category</th>
                                    <th width="100%">Title</th>
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
    {{-- @include('administrator.blog.modal.detail') --}}
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
                    url: '{{ route('admin.blog.getData') }}',
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
                        data: 'category.nama',
                        name: 'category.nama'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        render: function(data, type, row, meta) {
                            if (row.status == 1) {
                                return 'Public';
                            } else {
                                return 'Private';
                            }
                        },
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
                            url: "{{ route('admin.blog.delete') }}",
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
        });
    </script>
@endpush
