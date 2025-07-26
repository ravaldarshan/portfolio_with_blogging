<!-- Modal Detail Module -->
<input type="hidden" id="kategori_id" value="{{Route::is('admin.blog.edit') ? $data->kategori_id : ''}}">
<div class="modal fade" tabindex="-1" role="dialog" id="modalKategori" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKategoriLabel">Kategori</h5>
                <button type="button" class="close" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalKategoriBody">
                <table class="table" id="datatableModalKategori">
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
                <button type="button" class="btn btn-primary" id="selectDataKategori">Pilih</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#modalKategori').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);

            // Get the value of inputkategoriProject
            var inputkategoriProject = $("#kategori_id").val();

            // Now, you can initialize a new DataTable on the same table.
            $("#datatableModalKategori").DataTable().destroy();
            $('#datatableModalKategori tbody').remove();
            var data_table_modal_kategori = $('#datatableModalKategori').DataTable({
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
                    url: '{{ route('admin.blog.getDataKategori') }}',
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
                    // Check if inputkategoriProject is not empty and data.id matches
                    if (inputkategoriProject && data.id == inputkategoriProject) {
                        $(row).addClass('selected');
                    }
                }
            });


            // Click event for row selection
            $('#datatableModalKategori tbody').on('click', 'tr', function() {
                // Remove selection from other rows
                $('#datatableModalKategori tbody tr').removeClass('selected');

                // Add selection to the clicked row
                $(this).addClass('selected');

                // var data = data_table_modal_kategori.row(this).data();

                // $("#inputKategori").val(data.id);
                // $("#inputKategoriName").val(data.nama);
            });

            // Click event for "Pilih" button
            $('#selectDataKategori').on('click', function() {
                // Get the selected row
                var selectedRow = $('#datatableModalKategori tbody tr.selected');

                // Check if any row is selected
                if (selectedRow.length > 0) {
                    // Execute the specified code
                    var data = data_table_modal_kategori.row(selectedRow).data();
                    $("#kategori_id").val(data.id);
                    $("#inputKategori").val(data.id);
                    $("#inputKategoriName").val(data.nama);
                    $('#buttonCloseModuleModal').click();
                } else {
                    // Inform the user that no row is selected
                    Swal.fire({
                        title: "Peringatan!",
                        text: "Pilih salah satu data.",
                        icon: "warning"
                    });
                }
            });
        });
    </script>
@endpush
