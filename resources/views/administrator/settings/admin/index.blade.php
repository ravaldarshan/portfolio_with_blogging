@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Settings</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">Settings</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.settings.admin') }}">Administrator</a></div>
            <div class="breadcrumb-item">General</div>
        </div>
    @endpush
    @push('section_title')
        Setting General
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.settings.admin.general.update') }}" method="post"
                    enctype="multipart/form-data" class="form" id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="namaAppField" class="form-label">Nama App</label>
                                <input type="text" id="namaAppField" class="form-control" placeholder="Masukan Nama App"
                                    value="{{ array_key_exists('nama_app_admin', $settings) ? $settings['nama_app_admin'] : '' }}"
                                    name="nama_app_admin" autocomplete="off" data-parsley-required="true">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="footerAppAdmin" class="form-label">Footer App Admin</label>
                                <input type="text" id="footerAppAdmin" class="form-control"
                                    placeholder="Masukan Footer App Admin"
                                    value="{{ array_key_exists('footer_app_admin', $settings) ? $settings['footer_app_admin'] : '' }}"
                                    name="footer_app_admin" autocomplete="off" data-parsley-required="true">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="logoAppAdminInputFile" class="form-label">Logo App Admin</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview-logo thumbnail mb20" data-trigger="fileinput">
                                        <img width="350px"
                                            src="{{ array_key_exists('logo_app_admin', $settings) ? img_src($settings['logo_app_admin'], 'settings') : '' }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="logoAppAdminInputFile" class="btn btn-light btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <input type="file" class="d-none" id="logoAppAdminInputFile"
                                                name="logo_app_admin">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="faviconAppAdminInputFile" class="form-label">Favicon</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview-favicon thumbnail mb20" data-trigger="fileinput">
                                        <img width="350px"
                                            src="{{ array_key_exists('favicon', $settings) ? img_src($settings['favicon'], 'settings') : '' }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="faviconAppAdminInputFile" class="btn btn-light btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <input type="file" class="d-none" id="faviconAppAdminInputFile" name="favicon">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="main-background-color" class="form-label">main-background-color</label>
                                <div class="input-group colorpickerinput">
                                    <input type="text" class="form-control" name="admin_main_background_color"
                                        value="{{ array_key_exists('admin_main_background_color', $settings) ? $settings['admin_main_background_color'] : '' }}"
                                        id="main-background-color" placeholder="Masukan Kode Warna" autocomplete="off"
                                        data-parsley-required="true">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" id="formSubmit" class="btn btn-primary mx-1 mb-1">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress" style="display: none;">
                                    Tunggu Sebentar...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button type="reset" class="btn btn-secondary mx-1 mb-1">Reset</button>
                            <a href="{{ route('admin.settings.admin') }}" class="btn btn-danger mx-1 mb-1">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Basic Tables end -->
@endsection
@push('css')
    <link rel="stylesheet"
        href="{{ template_stisla('modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
@endpush
@push('js')
    <script src="{{ template_stisla('modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tambahkan FileInput JavaScript -->
    <script src="{{ asset_administrator('assets/plugins/form-jasnyupload/fileinput.min.js') }}"></script>

    <script>
        const logoInputFile = document.getElementById("logoAppAdminInputFile");
        const previewContainerLogo = document.querySelector(".fileinput-preview-logo");

        logoInputFile.addEventListener("change", function() {
            const files = this.files;

            // Hapus gambar-gambar sebelumnya
            previewContainerLogo.innerHTML = '';

            // Ambil satu file saja
            const file = files[0];
            const imageType = /^image\//;

            if (imageType.test(file.type)) {
                const imgContainer = document.createElement("div");
                imgContainer.classList.add("img-thumbnail-container");

                const img = document.createElement("img");
                img.classList.add("img-thumbnail");
                img.width = 350; // Sesuaikan ukuran gambar sesuai kebutuhan
                img.src = URL.createObjectURL(file);

                imgContainer.appendChild(img);
                previewContainerLogo.appendChild(imgContainer);
            }
        });
        
        const faviconInputFile = document.getElementById("faviconAppAdminInputFile");
        const previewContainerFavicon = document.querySelector(".fileinput-preview-favicon");

        faviconInputFile.addEventListener("change", function() {
            const files = this.files;

            // Hapus gambar-gambar sebelumnya
            previewContainerFavicon.innerHTML = '';

            // Ambil satu file saja
            const file = files[0];
            const imageType = /^image\//;

            if (imageType.test(file.type)) {
                const imgContainer = document.createElement("div");
                imgContainer.classList.add("img-thumbnail-container");

                const img = document.createElement("img");
                img.classList.add("img-thumbnail");
                img.width = 350; // Sesuaikan ukuran gambar sesuai kebutuhan
                img.src = URL.createObjectURL(file);

                imgContainer.appendChild(img);
                previewContainerFavicon.appendChild(imgContainer);
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $(".colorpickerinput").colorpicker({
                format: 'hex',
                component: '.input-group-append',
            });

            $("#logoAppAdminInputFile").fileinput({
                showUpload: false, // Hilangkan tombol "Upload"
                showRemove: false, // Hilangkan tombol "Remove"
                language: 'id', // Gantilah LANG dengan bahasa yang sesuai
                // Tambahan opsi sesuai kebutuhan Anda
            });
            $("#faviconInputFile").fileinput({
                showUpload: false, // Hilangkan tombol "Upload"
                showRemove: false, // Hilangkan tombol "Remove"
                language: 'id', // Gantilah LANG dengan bahasa yang sesuai
                // Tambahan opsi sesuai kebutuhan Anda
            });

            //validate parsley form
            const form = document.getElementById("form");
            const validator = $(form).parsley();

            const submitButton = document.getElementById("formSubmit");

            // form.addEventListener('keydown', function(e) {
            //     if (e.key === 'Enter') {
            //         e.preventDefault();
            //     }
            // });

            submitButton.addEventListener("click", async function(e) {
                e.preventDefault();
                indicatorBlock();

                // Validate the form using Parsley
                if ($(form).parsley().validate()) {
                    indicatorSubmit();

                    // Submit the form
                    form.submit();
                } else {
                    // Handle validation errors
                    const validationErrors = [];
                    $(form).find(':input').each(function() {
                        const field = $(this);
                        if (!field.parsley().isValid()) {
                            indicatorNone();
                            const attrName = field.attr('name');
                            const errorMessage = field.parsley().getErrorsMessages().join(
                                ', ');
                            validationErrors.push(attrName + ': ' + errorMessage);
                        }
                    });
                    console.log("Validation errors:", validationErrors.join('\n'));
                }
            });

            function indicatorSubmit() {
                submitButton.querySelector('.indicator-label').style.display =
                    'inline-block';
                submitButton.querySelector('.indicator-progress').style.display =
                    'none';
            }

            function indicatorNone() {
                submitButton.querySelector('.indicator-label').style.display =
                    'inline-block';
                submitButton.querySelector('.indicator-progress').style.display =
                    'none';
                submitButton.disabled = false;
            }

            function indicatorBlock() {
                // Disable the submit button and show the "Please wait..." message
                submitButton.disabled = true;
                submitButton.querySelector('.indicator-label').style.display = 'none';
                submitButton.querySelector('.indicator-progress').style.display =
                    'inline-block';
            }

        });
    </script>
@endpush
