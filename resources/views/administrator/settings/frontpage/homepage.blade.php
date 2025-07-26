@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Settings</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">Settings</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.settings.frontpage') }}">Frontpage</a></div>
            <div class="breadcrumb-item">Homepage</div>
        </div>
    @endpush
    @push('section_title')
        Setting Homepage
    @endpush
    <!-- Basic Tables start -->
    

    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.settings.frontpage.homepage.update') }}" method="post"
                    enctype="multipart/form-data" class="form" id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header">
                            <h4>Section Service</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                
                                <div class="row mb-3">
                                    <div class="col-md-6 col-12">
                                        <a href="{{ route('web.index') }}#sectionService" id="triggerPromosi"
                                            class="play-btn window-popup"><i class="fa fa-play"></i> Preview </a>
                                    </div>
                                </div>
                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mandatory">
                                            <label for="inputBodyService" class="form-label">Body</label>
                                            <textarea name="body_service_frontpage_homepage" class="form-control" id="inputBodyService" placeholder="Masukan Body"
                                                cols="30" rows="100" autocomplete="off" data-parsley-required="true">{{ array_key_exists('body_service_frontpage_homepage', $settings) ? $settings['body_service_frontpage_homepage'] : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Section Promosi</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                
                                <div class="row mb-3">
                                    <div class="col-md-6 col-12">
                                        <a href="{{ route('web.index') }}#sectionPromosi" id="triggerPromosi"
                                            class="play-btn window-popup"><i class="fa fa-play"></i> Preview </a>
                                    </div>
                                </div>
            
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="inputTitle" class="form-label">Title</label>
                                            <input type="text" id="inputTitle" class="form-control" placeholder="Masukan Title"
                                                value="{{ array_key_exists('title_promosi_frontpage_homepage', $settings) ? $settings['title_promosi_frontpage_homepage'] : '' }}"
                                                name="title_promosi_frontpage_homepage" data-parsley-required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mandatory">
                                            <label for="inputBody" class="form-label">Body</label>
                                            <textarea name="body_promosi_frontpage_homepage" class="form-control" id="inputBody" placeholder="Masukan Body"
                                                cols="30" rows="100" autocomplete="off" data-parsley-required="true">{{ array_key_exists('body_promosi_frontpage_homepage', $settings) ? $settings['body_promosi_frontpage_homepage'] : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mandatory">
                                            <label for="inputTextButton" class="form-label">Text Button</label>
                                            <input type="text" id="inputTextButton" class="form-control"
                                                placeholder="Masukan Text Button"
                                                value="{{ array_key_exists('text_button_promosi_frontpage_homepage', $settings) ? $settings['text_button_promosi_frontpage_homepage'] : '' }}"
                                                name="text_button_promosi_frontpage_homepage" data-parsley-required="true"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mandatory">
                                            <label for="inputUrlButton" class="form-label">Url Button</label>
                                            <input type="text" id="inputUrlButton" class="form-control"
                                                placeholder="Masukan Url Button"
                                                value="{{ array_key_exists('url_button_promosi_frontpage_homepage', $settings) ? $settings['url_button_promosi_frontpage_homepage'] : '' }}"
                                                name="url_button_promosi_frontpage_homepage" data-parsley-required="true"
                                                autocomplete="off">
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

    <!-- Basic Tables end -->
@endsection

@push('css')
    <link rel="stylesheet" href="{{ template_frontpage('css/magnific-popup.css') }}" type="text/css">
@endpush

@push('js')
    <!-- Tambahkan FileInput JavaScript -->
    <script src="{{ template_frontpage('js/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ asset_administrator('assets/plugins/form-jasnyupload/fileinput.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('.window-popup').magnificPopup({
                type: 'iframe'
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
