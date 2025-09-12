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
                                <input type="text" id="inputNamaApp" class="form-control" placeholder="Enter Nama App"
                                    value="{{ array_key_exists('general_nama_app', $settings) ? $settings['general_nama_app'] : '' }}"
                                    name="general_nama_app" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="otherPicturesInputFile" class="form-label">Favicon</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview-image thumbnail mb20">
                                        <img width="200px"
                                            src="{{ array_key_exists('general_frontpage_favicon', $settings) ? img_src($settings['general_frontpage_favicon'], 'settings') : '' }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="otherPicturesInputFile" class="btn btn-light btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <input type="file" class="d-none" id="otherPicturesInputFile"
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
                            <div id="socialMedia">
                                @php
                                    $socialMedia = array_key_exists('general_socialMedia', $settings) ? json_decode($settings['general_socialMedia']) : '';
                                    if (!empty($socialMedia)) {
                                        $jumlah_socialMedia = count($socialMedia);
                                    }else {
                                        $jumlah_socialMedia = 1;
                                    }
                                @endphp
                                <div class="socialMedia-list" index-element="{{ $jumlah_socialMedia - 1 }}">
                                    @if (!empty($socialMedia))
                                    @foreach ($socialMedia as $i => $row)
                                        <div class="row rowSocialMedia_{{ $i }}">
                                            {{-- {{dd($socialMedia)}} --}}
                                            <div class="col-md-5 col-11">
                                                <div class="form-group">
                                                    <label for="inputNamaSocialMedia_{{ $i }}"
                                                        class="form-label">Sosial Media (url)</label>
                                                    <input type="text" name="nama_socialMedia_{{ $i }}"
                                                        value="{{ $row->nama_socialMedia }}" class="form-control"
                                                        id="inputNamaSocialMedia_{{ $i }}" data-parsley-required="true"
                                                        placeholder="Enter Nama Sosial Media" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-11">
                                                <div class="form-group">
                                                    <label for="inputFontAawesomeSocialMedia_{{ $i }}"
                                                        class="form-label">Icon Sosial
                                                        Media (fontawesome 4)</label>
                                                    <input type="text" name="icon_socialMedia_{{ $i }}"
                                                        value="{{ $row->icon_socialMedia }}" class="form-control"
                                                        id="inputFontAawesomeSocialMedia_{{ $i }}" data-parsley-required="true"
                                                        placeholder="Enter Icon Sosial Media (contoh 'fa fa-instagram')" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-1">
                                                <button class="btn btn-danger btn-sm delete-socialMedia"
                                                    @if ($i === 0) style="display: none" @endif
                                                    data-socialMedia="{{$row->nama_socialMedia}}" data-index="{{ $i }}" type="button"><i
                                                        class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endif
                                </div>
                                <input type="hidden" name="jumlah_socialMedia" value="{{ $jumlah_socialMedia }}" id="jumlah_socialMedia">
                                <!-- Cloned socialMedia-list will be inserted here -->
                            </div>
                            <button class="more-socialMedia btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i> Add
                                more socialMedia</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="main-text-color" class="form-label">main-text-color</label>
                                <div class="input-group colorpickerinput">
                                    <input type="text" class="form-control" name="general_main_text_color"
                                        value="{{ array_key_exists('general_main_text_color', $settings) ? $settings['general_main_text_color'] : '' }}"
                                        id="main-text-color" placeholder="Enter Code Warna" autocomplete="off"
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
                                        id="breadcrumb-color" placeholder="Enter Code Warna" autocomplete="off"
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
                                        id="primary-color" placeholder="Enter Code Warna" autocomplete="off"
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
                                        id="background-color" placeholder="Enter Code Warna" autocomplete="off"
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
                                        id="counter-color" placeholder="Enter Code Warna" autocomplete="off"
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
                                        id="service-item-icon-color" placeholder="Enter Code Warna" autocomplete="off"
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
                                    Wait a moment...
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

    <div class="template-socialMedia d-none">
        <div class="col-md-5 col-11">
            <div class="form-group">
                <label for="inputNamaSocialMedia_0" class="form-label">Sosial Media</label>
                <input type="text" name="nama_socialMedia_0" class="form-control" id="inputNamaSocialMedia_0" data-parsley-required="true"
                    placeholder="Enter Nama Sosial Media" autocomplete="off">
            </div>
        </div>
        <div class="col-md-6 col-11">
            <div class="form-group">
                <label for="inputFontAawesomeSocialMedia_0" class="form-label">Icon Sosial
                    Media</label>
                <input type="text" name="icon_socialMedia_0" class="form-control" id="inputFontAawesomeSocialMedia_0" data-parsley-required="true"
                    placeholder="contoh = 'fa fa-instagram'" autocomplete="off">
            </div>
        </div>
        <div class="col-md-1 col-1">
            <button class="btn btn-danger btn-sm delete-socialMedia" style="display: none" data-index="0" data-socialMedia=""
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
            function addSocialMediaList() {
                
                var currentIndex = $(".socialMedia-list").find('.row').length;
                $('#jumlah_socialMedia').val((currentIndex + 1));

                
                var clonedElement = $(".template-socialMedia").clone();
                clonedElement.addClass("row rowSocialMedia_" + currentIndex);
                clonedElement.removeClass("template-socialMedia");
                clonedElement.removeClass("d-none");

                
                clonedElement.attr("index-element", currentIndex);

                
                clonedElement.find("[id^='inputNamaSocialMedia_']").attr("id", "inputNamaSocialMedia_" + currentIndex);
                clonedElement.find("[id^='inputFontAawesomeSocialMedia_']").attr("id", "inputFontAawesomeSocialMedia_" +
                    currentIndex);

                clonedElement.find("[for^='inputNamaSocialMedia_']").attr("for", "inputNamaSocialMedia_" + currentIndex);
                clonedElement.find("[for^='inputFontAawesomeSocialMedia_']").attr("for", "inputFontAawesomeSocialMedia_" +
                    currentIndex);

                
                clonedElement.find("[name^='nama_socialMedia_']").attr("name", "nama_socialMedia_" + currentIndex);
                clonedElement.find("[name^='icon_socialMedia_']").attr("name", "icon_socialMedia_" + currentIndex);

                clonedElement.find(".delete-socialMedia").attr("data-index", currentIndex);

                
                $(".socialMedia-list").append(clonedElement);

                
                $(".socialMedia-list .delete-socialMedia").show();
                $(".socialMedia-list .rowSocialMedia_0 .delete-socialMedia").hide();
            }

            
            function deleteSocialMediaList(element, index) {
                var socialMediaList = $(element).find(".rowSocialMedia_" + index);

                
                if (socialMediaList.attr("index-element") !== "0") {
                    socialMediaList.remove();
                    const jmlah = parseInt($('#jumlah_socialMedia').val()) - 1;
                    $('#jumlah_socialMedia').val(jmlah);
                }
            }

            
            $(".more-socialMedia").click(function() {
                addSocialMediaList();
            });

            
            $("#socialMedia").on("click", ".delete-socialMedia", function() {
                let index = $(this).data('index');
                let socialMedia = $(this).data('socialMedia');
                let socialMediaList = $(this).closest(".socialMedia-list");

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure you want to delete this data??',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, I am sure!',
                    cancelButtonText: 'No, Cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (socialMedia !== '') {
                            $.ajax({
                                type: "GET",
                                url: "{{ route('admin.settings.frontpage.general.deleteSocialMedia') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "_method": "GET",
                                    "index": index, 
                                    "socialMedia": socialMedia, 
                                },
                                success: function() {
                                    deleteSocialMediaList(socialMediaList, index);
                                    swalWithBootstrapButtons.fire({
                                        title: 'Succeed!',
                                        text: 'Data deleted successfully.',
                                        icon: 'success',
                                        timer: 1500, 
                                        showConfirmButton: false,
                                    });
                                }
                            });
                        } else {
                            deleteSocialMediaList(socialMediaList, index);
                            swalWithBootstrapButtons.fire({
                                title: 'Succeed!',
                                text: 'Data deleted successfully.',
                                icon: 'success',
                                timer: 1500, 
                                showConfirmButton: false,
                            });
                        }
                    }
                });
            });

            
            $(".socialMedia-list[index-element='0'] .delete-socialMedia").hide();
        });
    </script>

    <script>
        
        function handleFileInputChange() {
            const newInput = this; 

            
            const newFiles = newInput.files;

            
            for (let i = 0; i < newFiles.length; i++) {
                const newFile = newFiles[i];

                
                console.log(`File Baru: ${newFile.name}, Tipe: ${newFile.type}, Ukuran: ${newFile.size} bytes`);
            }

            
        }

        
        let filesArray = [];

        const otherPicturesInputFile = document.getElementById("otherPicturesInputFile");
        const previewContainerotherPictures = document.querySelector(".fileinput-preview-image");

        otherPicturesInputFile.addEventListener("change", function() {
            
            previewContainerotherPictures.innerHTML = '';

            const files = this.files;

            
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
                img.width = 200; 
                img.src = URL.createObjectURL(file);

                imgContainer.appendChild(img);
                previewContainerotherPictures.appendChild(imgContainer);

                
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

            
            const form = document.getElementById("form");
            const validator = $(form).parsley();

            const submitButton = document.getElementById("formSubmit");

            submitButton.addEventListener("click", async function(e) {
                e.preventDefault();
                indicatorBlock();

                
                if ($(form).parsley().validate()) {
                    indicatorSubmit();
                        
                        form.submit();
                } else {
                    
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
                
                submitButton.disabled = true;
                submitButton.querySelector('.indicator-label').style.display = 'none';
                submitButton.querySelector('.indicator-progress').style.display =
                    'inline-block';
            }

        });
    </script>
@endpush
