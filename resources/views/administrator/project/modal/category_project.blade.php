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

            // Get the value of inputcategoryProject
            var inputcategoryProject = $("#category_project_id").val();

            // Now, you can initialize a new DataTable on the same table.
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
                // scrollX: true, // Enable horizontal scrolling
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
                    // Check if inputcategoryProject is not empty and data.id matches
                    if (inputcategoryProject && data.id == inputcategoryProject) {
                        $(row).addClass('selected');
                    }
                }
            });


            // Click event for row selection
            $('#datatableModalCategoryProject tbody').on('click', 'tr', function() {
                // Remove selection from other rows
                $('#datatableModalCategoryProject tbody tr').removeClass('selected');

                // Add selection to the clicked row
                $(this).addClass('selected');

                // var data = data_table_modal_category_project.row(this).data();

                // $("#inputCategoryProject").val(data.id);
                // $("#inputCategoryProjectName").val(data.nama);
            });

            // Click event for "Choose" button
            $('#selectDataCategoryProject').on('click', function() {
                // Get the selected row
                var selectedRow = $('#datatableModalCategoryProject tbody tr.selected');

                // Check if any row is selected
                if (selectedRow.length > 0) {
                    // Execute the specified code
                    var data = data_table_modal_category_project.row(selectedRow).data();
                    $("#category_project_id").val(data.id);
                    $("#inputCategoryProject").val(data.id);
                    $("#inputCategoryProjectName").val(data.nama);
                    $('#buttonCloseModuleModal').click();
                } else {
                    // Inform the user that no row is selected
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
