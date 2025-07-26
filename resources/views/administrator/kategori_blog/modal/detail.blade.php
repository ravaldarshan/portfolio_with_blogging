<!-- Modal Detail KategoriProject -->
<div class="modal fade" tabindex="-1" role="dialog" id="detailKategoriBlog" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailKategoriBlogLabel">Detail Kategori Project</h5>
                <button type="button" class="close" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailKategoriBlogBody">
                
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#detailKategoriBlog').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modalBody = $('#detailKategoriBlogBody');
            modalBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.kategori_blog.getDetail', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    var data = response.data;

                    modalBody.html(
                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">ID</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.id + '</div>' +
                        '</div>' +
                        '</div>' +
                        
                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Nama</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.nama + '</div>' +
                        '</div>' +
                        '</div>' +
                        
                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Slug</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.slug + '</div>' +
                        '</div>' +
                        '</div>' +
                        
                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Status</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + (data.status == 1 ? 'Public' : 'Private') + '</div>' +
                        '</div>' +
                        '</div>' 
                    );

                    if (data.blog != '') {
                        modalBody.append('<br><strong>Blog</strong><br>');

                        for (let i = 0; i < data.blog.length; i++) {
                            const data_blog = data.blog[i];

                            modalBody.append(
                                '<div class="row">' +
                                '<div class="col-5">' +
                                '<div class="title">ID</div>' +
                                '</div>' +
                                '<div class="col-7">' +
                                '<div class="data">: ' + data_blog.id + '</div>' +
                                '</div>' +
                                '</div>' +

                                '<div class="row">' +
                                '<div class="col-5">' +
                                '<div class="title">Nama</div>' +
                                '</div>' +
                                '<div class="col-7">' +
                                '<div class="data">: ' + data_blog.nama + '</div>' +
                                '</div>' +
                                '</div>' +
                        
                                '<div class="row">' +
                                '<div class="col-5">' +
                                '<div class="title">Slug</div>' +
                                '</div>' +
                                '<div class="col-7">' +
                                '<div class="data">: ' + data_blog.slug + '</div>' +
                                '</div>' +
                                '</div>' +
                        
                                '<div class="row">' +
                                '<div class="col-5">' +
                                '<div class="title">Deskripsi</div>' +
                                '</div>' +
                                '<div class="col-7">' +
                                '<div class="data">: ' + data_blog.deskripsi + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<br>'
                            );
                        }
                    }

                    loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
                }
            });
        });
    </script>
@endpush
