@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Blog</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.blog') }}">Blog</a></div>
            <div class="breadcrumb-item">Add</div>
        </div>
    @endpush
    @push('section_title')
        Blog
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.blog.save') }}" method="post" enctype="multipart/form-data" class="form"
                    id="form" data-parsley-validate>
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="inputCategoryName" class="form-label">Category</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputCategoryName" readonly>
                                    <div class="input-group-append">
                                        <a href="#" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modalCategory">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </div>
                                    <input type="text" class="d-none" name="category" id="inputCategory"
                                        data-parsley-required="true" aria-labelledby="inputCategoryNameLabel">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputDatePosting" class="form-label">Posting Date</label>
                                <input type="text" id="inputDatePosting" class="form-control"
                                    placeholder="Choose Posting Date" name="posting_date" autocomplete="off"
                                    data-parsley-required="true">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputTitle" class="form-label">Title</label>
                                <input type="text" id="inputTitle" class="form-control" placeholder="Title"
                                    name="title" autocomplete="off" data-parsley-required="true">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="otherPicturesInputFile" class="form-label">More Images</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview-other_pictures thumbnail mb20">
                                    </div>
                                    <div class="mt-3">
                                        <label for="otherPicturesInputFile" class="btn btn-light btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <input type="file" class="d-none" id="otherPicturesInputFile"
                                                data-parsley-required="true" name="img[]" multiple>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="inputContents" class="form-label">Contents</label>
                                <textarea name="contents" id="inputContents" class="form-control summernote" placeholder="Enter Contents Blog"
                                    autocomplete="off" data-parsley-required="true"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class='form-group mandatory'>
                                <fieldset>
                                    <label class="form-label">
                                        Status
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="1"
                                            id="flexRadioDefault1" checked data-parsley-required="true">
                                        <label class="form-check-label form-label" for="flexRadioDefault1">
                                            Public
                                        </label>
                                    </div>
                                </fieldset>
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
                            <a href="{{ route('admin.blog') }}" class="btn btn-danger me-1 mb-1">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('administrator.blog.modal.category')
    <!-- Basic Tables end -->
@endsection

@push('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

            $('#inputDatePosting').datepicker({
                language:'id',
                format:'dd-mm-yyyy',

            });

            //validate parsley form
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
