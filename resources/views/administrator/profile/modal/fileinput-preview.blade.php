<!-- Modal fileinput-preview-profile -->
<div class="modal fade" tabindex="-1" role="dialog" id="fileinput-preview-profile" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileinput-preview-profileLabel">Filter Module</h5>
                <button type="button" class="close" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="fileinput-preview-profileBody">
                <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="kode" value="{{ $data->user->kode ? $data->user->kode : '' }}">
                    <input type="hidden" name="email" value="{{ $data->user->email ? $data->user->email : '' }}">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput">
                                <img src="{{img_src($data->foto, 'profile') ? img_src($data->foto, 'profile') : ''}}" alt="Admin"
                                    class="rounded-circle" width="150">
                            </div>
                            <div class="my-3">
                                <label for="userFotoInputFile" class="btn btn-outline-primary btn-file">
                                    <span class="fileinput-new ">Select Image</span>
                                    <input type="file" class="d-none" id="userFotoInputFile"
                                        name="foto_user_profile">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
    {{-- Tambahkan FileInput JavaScript --}}
    <script>
        $("#userFotoInputFile").fileinput({
            showUpload: false, // Hilangkan tombol "Upload"
            showRemove: false, // Hilangkan tombol "Remove"
            language: 'id', // Gantilah LANG dengan bahasa yang sesuai
            // Tambahan opsi sesuai kebutuhan Anda
        });
    </script>
@endpush
