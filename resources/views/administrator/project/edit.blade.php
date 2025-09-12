@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Project</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.project') }}">Project</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    @endpush
    @push('section_title')
        Project
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.project.update') }}" method="post" enctype="multipart/form-data"
                    class="form" id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="inputId" value="{{ $data->id }}">

                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="inputCategoryProjectName" class="form-label">Category</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputCategoryProjectName"
                                        value="{{ $data->category_project->nama }}" readonly>
                                    <div class="input-group-append">
                                        <a href="#" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modalCategoryProject">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </div>
                                    <input type="text" class="d-none" name="category_project" id="inputCategoryProject"
                                        value="{{ $data->category_project->id }}" data-parsley-required="true"
                                        aria-labelledby="inputCategoryProjectNameLabel">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputNama" class="form-label">Nama</label>
                                <input type="text" id="inputNama" class="form-control" placeholder="Enter Nama"
                                    value="{{ $data->nama }}" name="nama" autocomplete="off"
                                    data-parsley-required="true">
                                <div class="" style="color: #dc3545" id="accessErrorNama"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="otherPicturesInputFile" class="form-label">More Images</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview-other_pictures thumbnail mb20">
                                        @if (!empty($decodeImg))
                                            @foreach ($decodeImg as $img)
                                                <div class="img-thumbnail-container" id="{{ $img }}"><img
                                                        class="img-thumbnail" width="200"
                                                        src="{{ img_src($img, 'project') }}"><a
                                                        class="btn btn-danger btn-sm deleteImgid"
                                                        data-img="{{ $img }}"
                                                        data-id="{{ $data->id }}">Wipe</a></div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="mt-3">
                                        <label for="otherPicturesInputFile" class="btn btn-light btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <input type="file" class="d-none" id="otherPicturesInputFile"
                                                {{$decodeImg ? '' : 'data-parsley-required="true"'}} name="img[]" multiple>
                                            <!-- Tambahkan atribut "multiple" di sini -->
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="inputDescription" class="form-label">Description</label>
                                <textarea name="description" id="inputDescription" class="form-control summernote" placeholder="Enter Description"
                                    autocomplete="off" data-parsley-required="true">{{ $data->description }}</textarea>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" id="formSubmit" class="btn btn-primary me-1 mb-1">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress" style="display: none;">
                                    Wait a moment...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button type="reset" class="btn btn-secondary mx-2 mb-1">Reset</button>
                            <a href="{{ route('admin.project') }}" class="btn btn-danger me-1 mb-1">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('administrator.project.modal.category_project')
    <!-- Basic Tables end -->
@endsection

@push('js')
    <script>
        $(document).on('click', '.deleteImgid', function(event) {
            const id = $(this).data('id');
            var img = $(this).data('img');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-4',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure you want to delete this image?',
                icon: 'warning',
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: 'No, Cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.project.deleteImage') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "GET",
                            "id": id,
                            "img": img,
                        },
                        success: function() {
                            let container = document.getElementById(img);
                            if (container !== null) {
                                container.remove();
                            } else {
                                console.error('Element with ID ' + img + ' not found.');
                            }
                        }
                    });
                }
            });
        });

        
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
        const previewContainerotherPictures = document.querySelector(".fileinput-preview-other_pictures");

        otherPicturesInputFile.addEventListener("change", function() {
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

                const deleteButton = document.createElement("a");
                deleteButton.classList.add("btn", "btn-danger", "btn-sm", "deleteImg");
                deleteButton.textContent = "Wipe";
                deleteButton.addEventListener("click", function() {

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success mx-4',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    });

                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure you want to delete this image?',
                        icon: 'warning',
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: 'Yes, I am sure!',
                        cancelButtonText: 'No, Cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {

                            
                            const fileIndex = filesArray.indexOf(file);
                            if (fileIndex !== -1) {
                                filesArray.splice(fileIndex, 1);

                                
                                const newFilesList = new DataTransfer();

                                
                                filesArray.forEach(file => newFilesList.items.add(file));

                                
                                otherPicturesInputFile.files = newFilesList.files;

                                
                                otherPicturesInputFile.addEventListener("change",
                                    handleFileInputChange);
                            }

                            imgContainer.remove();
                        }
                    });
                });

                imgContainer.appendChild(img);
                imgContainer.appendChild(deleteButton);
                previewContainerotherPictures.appendChild(imgContainer);

                
                filesArray.push(file);
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            
            const form = document.getElementById("form");
            const validator = $(form).parsley();

            const submitButton = document.getElementById("formSubmit");

            
            
            
            
            

            submitButton.addEventListener("click", async function(e) {
                e.preventDefault();
                indicatorBlock();

                
                const remoteValidationResult = await validateRemoteNama();
                const inputNama = $("#inputNama");
                const accessErrorNama = $("#accessErrorNama");
                if (!remoteValidationResult.valid) {
                    
                    accessErrorNama.addClass('invalid-feedback');
                    inputNama.addClass('is-invalid');

                    accessErrorNama.text(remoteValidationResult
                        .errorMessage); 
                    indicatorNone();
                    return;
                } else {
                    accessErrorNama.removeClass('invalid-feedback');
                    inputNama.removeClass('is-invalid');
                    accessErrorNama.text('');
                }


                
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

            var inputId = $('#inputId').val();

            async function validateRemoteNama() {
                const inputNama = $('#inputNama');
                const remoteValidationUrl = "{{ route('admin.project.checkNama') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            nama: inputNama.val(),
                            id: inputId
                        }
                    });

                    
                    return {
                        valid: response.valid === true,
                        errorMessage: response.message
                    };
                } catch (error) {
                    console.error("Remote validation error:", error);
                    return {
                        valid: false,
                        errorMessage: "An error occurred during validation."
                    };
                }
            }
        });
    </script>
@endpush
