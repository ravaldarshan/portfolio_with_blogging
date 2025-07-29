@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Banner</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.banner') }}">Banner</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    @endpush
    @push('section_title')
        Banner
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.banner.update') }}" method="post" enctype="multipart/form-data"
                    class="form" id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')

                    <div id="accordion">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="accordion">
                                <div class="accordion-header" role="button" data-toggle="collapse"
                                    data-target="#banner-accordion-{{ $i }}"
                                    aria-expanded="{{ $i == 0 ? 'true' : 'false' }}">
                                    <h4>Banner {{ $i + 1 }}</h4>
                                </div>
                                <div class="accordion-body collapse {{ $i == 0 ? 'show' : '' }}"
                                    id="banner-accordion-{{ $i }}" data-parent="#accordion">
                                    <input type="hidden" name="id_{{ $i }}" id="inputId_{{ $i }}">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview_{{ $i }} thumbnail mb20">
                                            <div class="img-thumbnail-container">
                                                <img class="img-thumbnail" width="200"
                                                    src="{{ array_key_exists('banner_' . $i, $data) ? img_src(json_decode($data['banner_' . $i])->img_url, 'banner') : '' }}">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <label for="iconInputFile_{{ $i }}" class="btn btn-light btn-file">
                                                <span class="fileinput-new">Select a single image</span>
                                                <input type="file" class="d-none" id="iconInputFile_{{ $i }}"
                                                    name="icon_{{ $i }}">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="inputTitle_{{ $i }}"
                                                    class="form-label">Title</label>
                                                <input type="text" id="inputTitle_{{ $i }}"
                                                    class="form-control" placeholder="Enter Title"
                                                    value="{{ array_key_exists('banner_' . $i, $data) ? json_decode($data['banner_' . $i])->title : '' }}"
                                                    name="title_{{ $i }}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mandatory">
                                                <label for="inputBody_{{ $i }}" class="form-label">Body</label>
                                                <textarea name="body_{{ $i }}" id="inputBody_{{ $i }}" class="form-control"
                                                    placeholder="Enter Body" autocomplete="off">{{ array_key_exists('banner_' . $i, $data) ? json_decode($data['banner_' . $i])->body : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
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
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Basic Tables end -->
@endsection

@push('js')
    <script>
        for (let index = 0; index < 3; index++) {
            const otherPicturesInputFile = document.getElementById("iconInputFile_" + index);
            const previewContainerotherPictures = document.querySelector(".fileinput-preview_" + index);

            otherPicturesInputFile.addEventListener("change", function() {
                const files = this.files;
                previewContainerotherPictures.innerHTML = '';
                const file = files[0];
                const imageType = /^image\//;

                if (imageType.test(file.type)) {
                    const imgContainer = document.createElement("div");
                    imgContainer.classList.add("img-thumbnail-container");

                    const img = document.createElement("img");
                    img.classList.add("img-thumbnail");
                    img.width = 200;
                    img.src = URL.createObjectURL(file);

                    imgContainer.appendChild(img);
                    previewContainerotherPictures.appendChild(imgContainer);
                }
            });
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

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
