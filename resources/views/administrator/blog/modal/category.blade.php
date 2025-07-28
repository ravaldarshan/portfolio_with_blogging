<!-- Modal Detail Module -->
<input type="hidden" id="category_id" value="{{Route::is('admin.blog.edit') ? $data->category_id : ''}}">
<div class="modal fade" tabindex="-1" role="dialog" id="modalCategory" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCategoryLabel">Category</h5>
                <button type="button" class="close" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalCategoryBody">
                <table class="table" id="datatableModalCategory">
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
                <button type="button" class="btn btn-primary" id="selectDataCategory">Choose</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#modalCategory').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var inputcategoryProject = $("#category_id").val();
            // Now, you can initialize a new DataTable on the same table.
            $("#datatableModalCategory").DataTable().destroy();
            $('#datatableModalCategory tbody').remove();
            var data_table_modal_category = $('#datatableModalCategory').DataTable({
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
                    url: '{{ route('admin.blog.getDataCategory') }}',
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
            $('#datatableModalCategory tbody').on('click', 'tr', function() {
                // Remove selection from other rows
                $('#datatableModalCategory tbody tr').removeClass('selected');

                // Add selection to the clicked row
                $(this).addClass('selected');

                // var data = data_table_modal_category.row(this).data();

                // $("#inputCategory").val(data.id);
                // $("#inputCategoryName").val(data.nama);
            });

            // Click event for "Choose" button
            $('#selectDataCategory').on('click', function() {
                // Get the selected row
                var selectedRow = $('#datatableModalCategory tbody tr.selected');

                // Check if any row is selected
                if (selectedRow.length > 0) {
                    // Execute the specified code
                    var data = data_table_modal_category.row(selectedRow).data();
                    $("#category_id").val(data.id);
                    $("#inputCategory").val(data.id);
                    $("#inputCategoryName").val(data.nama);
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
