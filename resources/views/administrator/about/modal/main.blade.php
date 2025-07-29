<!-- Modal Detail Module -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalGallery" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGalleryLabel">Gallery</h5>
                <button type="button" class="close m-0" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalGalleryBody">

            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="selectData" class="btn btn-primary">Choose</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script type="text/javascript">
        $('#modalGallery').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);

            var modalBody = $('#modalGalleryBody');
            modalBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Loading...' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); 

            $.ajax({
                url: '{{ route('admin.about.getDataGallery') }}',
                method: 'GET',
                success: function(response) {
                    var datas = response.data;
                    var body = '';

                    for (let i = 0; i < datas.length; i++) {
                        const data = datas[i];
                        const img = JSON.parse(data.img_url);

                        for (let index = 0; index < img.length; index++) {
                            const img_url = img[index];
                            const checkboxId =
                                `checkbox_${i}_${index}`; 
                            body += `<div class="col-6 col-sm-4">` +
                                `<label class="imagecheck mb-4">` +
                                `<input name="imagecheck" id="${checkboxId}" type="checkbox" value="${img_url}" class="imagecheck-input" />` +
                                `<figure class="imagecheck-figure">` +
                                `<img src="{{ asset_administrator('assets/media/gallery') }}/${img_url}" alt="${img_url}" class="imagecheck-image">` +
                                `</figure>` +
                                `</label>` +
                                `</div>`;
                        }
                    }
                    modalBody.html(
                        `<div class="form-group">` +
                        `<label class="form-label">Image</label>` +
                        `<div class="row gutters-sm" id="gallery">` +

                        body +

                        `</div>` +
                        `</div>`
                    );
                    loadingSpinner.hide();
                }
            });

            $('#selectData').on('click', function() {
                var selectedImages = [];

                $('input[name="imagecheck"]:checked').each(function() {
                    selectedImages.push($(this).val());
                });

                if (selectedImages.length > 0 && selectedImages.length <= 3) {
                    var selectedImagesJSON = JSON.stringify(selectedImages);
                    $("#inputImage").val(selectedImagesJSON);
                    $('#buttonCloseModuleModal').click();
                } else {
                    Swal.fire({
                        title: "Warning!",
                        text: "Choose between 1 to 3 images.",
                        icon: "warning"
                    });
                }
            });
        });
    </script>
@endpush
