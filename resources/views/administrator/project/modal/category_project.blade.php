<!-- Modal Detail Module -->
<input type="hidden" id="category_project_id" value="{{Route::is('admin.project.edit') ? $data->category_project_id : ''}}">
<div class="modal fade" tabindex="-1" role="dialog" id="modalCategoryProject" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCategoryProjectLabel">Category</h5>
                <button type="button" class="close" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalCategoryProjectBody">
                <table class="table" id="datatableModalCategoryProject">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th width="">Nama</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="selectDataCategoryProject">Choose</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#modalCategoryProject').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);

            
            var inputcategoryProject = $("#category_project_id").val();

            
            $("#datatableModalCategoryProject").DataTable().destroy();
            $('#datatableModalCategoryProject tbody').remove();
            var data_table_modal_category_project = $('#datatableModalCategoryProject').DataTable({
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
                
                ajax: {
                    url: '{{ route('admin.project.getDataCategoryProject') }}',
                    dataType: "JSON",
                    type: "GET",
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
                ],
                "rowCallback": function(row, data) {
                    
                    if (inputcategoryProject && data.id == inputcategoryProject) {
                        $(row).addClass('selected');
                    }
                }
            });


            
            $('#datatableModalCategoryProject tbody').on('click', 'tr', function() {
                
                $('#datatableModalCategoryProject tbody tr').removeClass('selected');

                
                $(this).addClass('selected');

                

                
                
            });

            
            $('#selectDataCategoryProject').on('click', function() {
                
                var selectedRow = $('#datatableModalCategoryProject tbody tr.selected');

                
                if (selectedRow.length > 0) {
                    
                    var data = data_table_modal_category_project.row(selectedRow).data();
                    $("#category_project_id").val(data.id);
                    $("#inputCategoryProject").val(data.id);
                    $("#inputCategoryProjectName").val(data.nama);
                    $('#buttonCloseModuleModal').click();
                } else {
                    
                    Swal.fire({
                        title: "Warning!",
                        text: "Choose salah satu data.",
                        icon: "warning"
                    });
                }
            });
        });
    </script>
@endpush
