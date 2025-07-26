@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Settings</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">Settings</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.settings.frontpage') }}">Frontpage</a></div>
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
                <form action="{{ route('admin.settings.frontpage.general.update') }}" method="post"
                    enctype="multipart/form-data" class="form" id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputNamaApp" class="form-label">Nama App</label>
                                <input type="text" id="inputNamaApp" class="form-control" placeholder="Masukan Nama App"
                                    value="{{ array_key_exists('general_nama_app', $settings) ? $settings['general_nama_app'] : '' }}"
                                    name="general_nama_app" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="gambarLainnyaInputFile" class="form-label">Favicon</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview-image thumbnail mb20">
                                        <img width="200px"
                                            src="{{ array_key_exists('general_frontpage_favicon', $settings) ? img_src($settings['general_frontpage_favicon'], 'settings') : '' }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="gambarLainnyaInputFile" class="btn btn-light btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <input type="file" class="d-none" id="gambarLainnyaInputFile"
                                                name="general_frontpage_favicon">
                                            <!-- Tambahkan atribut "multiple" di sini -->
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-12">
                            <div id="sosmed">
                                @php
                                    $sosmed = array_key_exists('general_sosmed', $settings) ? json_decode($settings['general_sosmed']) : '';
                                    if (!empty($sosmed)) {
                                        $jumlah_sosmed = count($sosmed);
                                    }else {
                                        $jumlah_sosmed = 1;
                                    }
                                @endphp
                                <div class="sosmed-list" index-element="{{ $jumlah_sosmed - 1 }}">
                                    @if (!empty($sosmed))
                                    @foreach ($sosmed as $i => $row)
                                        <div class="row rowSosmed_{{ $i }}">
                                            {{-- {{dd($sosmed)}} --}}
                                            <div class="col-md-5 col-11">
                                                <div class="form-group">
                                                    <label for="inputNamaSosmed_{{ $i }}"
                                                        class="form-label">Sosial Media (url)</label>
                                                    <input type="text" name="nama_sosmed_{{ $i }}"
                                                        value="{{ $row->nama_sosmed }}" class="form-control"
                                                        id="inputNamaSosmed_{{ $i }}" data-parsley-required="true"
                                                        placeholder="Masukan Nama Sosial Media" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-11">
                                                <div class="form-group">
                                                    <label for="inputFontAawesomeSosmed_{{ $i }}"
                                                        class="form-label">Icon Sosial
                                                        Media (fontawesome 4)</label>
                                                    <input type="text" name="icon_sosmed_{{ $i }}"
                                                        value="{{ $row->icon_sosmed }}" class="form-control"
                                                        id="inputFontAawesomeSosmed_{{ $i }}" data-parsley-required="true"
                                                        placeholder="Masukan Icon Sosial Media (contoh 'fa fa-instagram')" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-1">
                                                <button class="btn btn-danger btn-sm delete-sosmed"
                                                    @if ($i === 0) style="display: none" @endif
                                                    data-sosmed="{{$row->nama_sosmed}}" data-index="{{ $i }}" type="button"><i
                                                        class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endif
                                </div>
                                <input type="hidden" name="jumlah_sosmed" value="{{ $jumlah_sosmed }}" id="jumlah_sosmed">
                                <!-- Cloned sosmed-list will be inserted here -->
                            </div>
                            <button class="more-sosmed btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i> Add
                                more sosmed</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="main-text-color" class="form-label">main-text-color</label>
                                <div class="input-group colorpickerinput">
                                    <input type="text" class="form-control" name="general_main_text_color"
                                        value="{{ array_key_exists('general_main_text_color', $settings) ? $settings['general_main_text_color'] : '' }}"
                                        id="main-text-color" placeholder="Masukan Kode Warna" autocomplete="off"
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
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="breadcrumb-color" class="form-label">breadcrumb-color</label>
                                <div class="input-group colorpickerinput">
                                    <input type="text" class="form-control" name="general_breadcrumb_color"
                                        value="{{ array_key_exists('general_breadcrumb_color', $settings) ? $settings['general_breadcrumb_color'] : '' }}"
                                        id="breadcrumb-color" placeholder="Masukan Kode Warna" autocomplete="off"
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
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="primary-color" class="form-label">primary-color</label>
                                <div class="input-group colorpickerinput">
                                    <input type="text" class="form-control" name="general_primary_color"
                                        value="{{ array_key_exists('general_primary_color', $settings) ? $settings['general_primary_color'] : '' }}"
                                        id="primary-color" placeholder="Masukan Kode Warna" autocomplete="off"
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
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="background-color" class="form-label">background-color</label>
                                <div class="input-group colorpickerinput">
                                    <input type="text" class="form-control" name="general_background_color"
                                        value="{{ array_key_exists('general_background_color', $settings) ? $settings['general_background_color'] : '' }}"
                                        id="background-color" placeholder="Masukan Kode Warna" autocomplete="off"
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
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="counter-color" class="form-label">counter-color</label>
                                <div class="input-group colorpickerinput">
                                    <input type="text" class="form-control" name="general_counter_color"
                                        value="{{ array_key_exists('general_counter_color', $settings) ? $settings['general_counter_color'] : '' }}"
                                        id="counter-color" placeholder="Masukan Kode Warna" autocomplete="off"
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
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="service-item-icon-color" class="form-label">service-item-icon-color</label>
                                <div class="input-group colorpickerinput">
                                    <input type="text" class="form-control" name="general_service_item_icon_color"
                                        value="{{ array_key_exists('general_service_item_icon_color', $settings) ? $settings['general_service_item_icon_color'] : '' }}"
                                        id="service-item-icon-color" placeholder="Masukan Kode Warna" autocomplete="off"
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
                            <a href="{{ route('admin.settings') }}" class="btn btn-danger mx-1 mb-1">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="template-sosmed d-none">
        <div class="col-md-5 col-11">
            <div class="form-group">
                <label for="inputNamaSosmed_0" class="form-label">Sosial Media</label>
                <input type="text" name="nama_sosmed_0" class="form-control" id="inputNamaSosmed_0" data-parsley-required="true"
                    placeholder="Masukan Nama Sosial Media" autocomplete="off">
            </div>
        </div>
        <div class="col-md-6 col-11">
            <div class="form-group">
                <label for="inputFontAawesomeSosmed_0" class="form-label">Icon Sosial
                    Media</label>
                <input type="text" name="icon_sosmed_0" class="form-control" id="inputFontAawesomeSosmed_0" data-parsley-required="true"
                    placeholder="contoh = 'fa fa-instagram'" autocomplete="off">
            </div>
        </div>
        <div class="col-md-1 col-1">
            <button class="btn btn-danger btn-sm delete-sosmed" style="display: none" data-index="0" data-sosmed=""
                type="button"><i class="fa fa-trash"></i></button>
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
        $(document).ready(function() {
            function addSosmedList() {
                // Use a class selector to get the count of cloned elements
                var currentIndex = $(".sosmed-list").find('.row').length;
                $('#jumlah_sosmed').val((currentIndex + 1));

                // Clone the template-sosmed
                var clonedElement = $(".template-sosmed").clone();
                clonedElement.addClass("row rowSosmed_" + currentIndex);
                clonedElement.removeClass("template-sosmed");
                clonedElement.removeClass("d-none");

                // Set the index-element attribute on the cloned element
                clonedElement.attr("index-element", currentIndex);

                // Update IDs and "for" attributes of cloned elements
                clonedElement.find("[id^='inputNamaSosmed_']").attr("id", "inputNamaSosmed_" + currentIndex);
                clonedElement.find("[id^='inputFontAawesomeSosmed_']").attr("id", "inputFontAawesomeSosmed_" +
                    currentIndex);

                clonedElement.find("[for^='inputNamaSosmed_']").attr("for", "inputNamaSosmed_" + currentIndex);
                clonedElement.find("[for^='inputFontAawesomeSosmed_']").attr("for", "inputFontAawesomeSosmed_" +
                    currentIndex);

                // Update name attributes of cloned input elements
                clonedElement.find("[name^='nama_sosmed_']").attr("name", "nama_sosmed_" + currentIndex);
                clonedElement.find("[name^='icon_sosmed_']").attr("name", "icon_sosmed_" + currentIndex);

                clonedElement.find(".delete-sosmed").attr("data-index", currentIndex);

                // Append the cloned element to the container
                $(".sosmed-list").append(clonedElement);

                // Show delete button for the new row, hide for the initial row
                $(".sosmed-list .delete-sosmed").show();
                $(".sosmed-list .rowSosmed_0 .delete-sosmed").hide();
            }

            // Function to handle deleting sosmed-list
            function deleteSosmedList(element, index) {
                var sosmedList = $(element).find(".rowSosmed_" + index);

                // Check if it is not the first row before deleting
                if (sosmedList.attr("index-element") !== "0") {
                    sosmedList.remove();
                    const jmlah = parseInt($('#jumlah_sosmed').val()) - 1;
                    $('#jumlah_sosmed').val(jmlah);
                }
            }

            // Event listener for "Add more sosmed" button
            $(".more-sosmed").click(function() {
                addSosmedList();
            });

            // Event listener for "Delete" button
            $("#sosmed").on("click", ".delete-sosmed", function() {
                let index = $(this).data('index');
                let sosmed = $(this).data('sosmed');
                let sosmedList = $(this).closest(".sosmed-list");

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Saya yakin!',
                    cancelButtonText: 'Tidak, Batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (sosmed !== '') {
                            $.ajax({
                                type: "GET",
                                url: "{{ route('admin.settings.frontpage.general.deleteSosmed') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "_method": "GET",
                                    "index": index, // Make sure you define the variable 'id' to be deleted
                                    "sosmed": sosmed, // Make sure you define the variable 'id' to be deleted
                                },
                                success: function() {
                                    deleteSosmedList(sosmedList, index);
                                    swalWithBootstrapButtons.fire({
                                        title: 'Berhasil!',
                                        text: 'Data berhasil dihapus.',
                                        icon: 'success',
                                        timer: 1500, // 2 detik
                                        showConfirmButton: false,
                                    });
                                }
                            });
                        } else {
                            deleteSosmedList(sosmedList, index);
                            swalWithBootstrapButtons.fire({
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success',
                                timer: 1500, // 2 detik
                                showConfirmButton: false,
                            });
                        }
                    }
                });
            });

            // Hide delete button for the initial row
            $(".sosmed-list[index-element='0'] .delete-sosmed").hide();
        });
    </script>

    <script>
        // Fungsi untuk menangani perubahan pada file input
        function handleFileInputChange() {
            const newInput = this; // 'this' mengacu pada elemen file input yang dipicu oleh perubahan

            // Mendapatkan file yang baru dipilih
            const newFiles = newInput.files;

            // Lakukan sesuatu dengan file yang baru dipilih
            for (let i = 0; i < newFiles.length; i++) {
                const newFile = newFiles[i];

                // Lakukan sesuatu dengan setiap file, misalnya, tampilkan informasi di konsol
                console.log(`File Baru: ${newFile.name}, Tipe: ${newFile.type}, Ukuran: ${newFile.size} bytes`);
            }

            // Anda dapat menambahkan logika lain sesuai kebutuhan Anda di sini
        }

        // Variabel untuk menyimpan array file
        let filesArray = [];

        const gambarLainnyaInputFile = document.getElementById("gambarLainnyaInputFile");
        const previewContainerGambarLainnya = document.querySelector(".fileinput-preview-image");

        gambarLainnyaInputFile.addEventListener("change", function() {
            // Hapus preview gambar sebelumnya
            previewContainerGambarLainnya.innerHTML = '';

            const files = this.files;

            // Loop melalui semua file yang dipilih
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const imageType = /^image\//;

                if (!imageType.test(file.type)) {
                    continue;
                }

                const imgContainer = document.createElement("div");
                imgContainer.classList.add("img-thumbnail-container");

                const img = document.createElement("img");
                img.classList.add("img-thumbnail");
                img.width = 200; // Sesuaikan ukuran gambar sesuai kebutuhan
                img.src = URL.createObjectURL(file);

                imgContainer.appendChild(img);
                previewContainerGambarLainnya.appendChild(imgContainer);

                // Tambahkan file ke dalam array
                filesArray.push(file);
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $(".colorpickerinput").colorpicker({
                format: 'hex',
                component: '.input-group-append',
            });

            //validate parsley form
            const form = document.getElementById("form");
            const validator = $(form).parsley();

            const submitButton = document.getElementById("formSubmit");

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
