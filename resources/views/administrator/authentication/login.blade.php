@extends('administrator.authentication.main')

@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="{{ array_key_exists('logo_app_admin', $settings) ? img_src($settings['logo_app_admin'], 'settings') : '' }}"
                            alt="logo" width="100" class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Login</h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.loginProses') }}" id="form"
                                class="needs-validation" novalidate="" data-parsley-validate>
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label for="inputEmail">Email</label>
                                    <input id="inputEmail" type="email" class="form-control" name="email" tabindex="1"
                                        data-parsley-required="true" data-parsley-type="email" data-parsley-trigger="change"
                                        data-parsley-error-message="Masukan alamat email yang valid." autocomplete="off"
                                        autofocus>
                                    <div class="" style="color: #dc3545" id="accessErrorEmail"></div>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="inputPassword" class="control-label">Password</label>
                                        <div class="float-right">
                                            <a href="javascript:void(0)" class="text-small">
                                                Forgot Password?
                                            </a>
                                        </div>
                                    </div>
                                    <input id="inputPassword" type="password" class="form-control" name="password"
                                        autocomplete="off" tabindex="2" data-parsley-required="true"
                                        data-parsley-minlength="8" data-parsley-trigger="change"
                                        data-parsley-error-message="Password harus memiliki setidaknya 8 karakter.">
                                    <div class="" style="color: #dc3545" id="accessErrorPassword"></div>
                                </div>

                                {{-- <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                            id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                    </div>
                                </div> --}}

                                <div class="form-group">
                                    <button type="submit" id="formSubmit" class="btn btn-primary btn-lg btn-block"
                                        tabindex="4">
                                        <span class="indicator-label">Login</span>
                                        <span class="indicator-progress" style="display: none;">
                                            Tunggu Sebentar...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="mt-5 text-muted text-center">
                        Don't have an account? <a href="auth-register.html">Create One</a>
                    </div> --}}
                    <div class="simple-footer">
                        {{ array_key_exists('footer_app_admin', $settings) ? $settings['footer_app_admin'] : '' }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
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


                // Perform remote validation
                const remoteValidationResultEmail = await validateRemoteEmail();
                const inputEmail = $("#inputEmail");
                const accessErrorEmail = $("#accessErrorEmail");
                if (!remoteValidationResultEmail.valid) {
                    // Remote validation failed, display the error message
                    accessErrorEmail.addClass('invalid-feedback');
                    inputEmail.addClass('is-invalid');

                    accessErrorEmail.text(remoteValidationResultEmail
                        .errorMessage); // Set the error message from the response
                    indicatorNone();

                    return;
                } else {
                    accessErrorEmail.removeClass('invalid-feedback');
                    inputEmail.removeClass('is-invalid');
                    accessErrorEmail.text('');
                }

                // Perform remote validation
                const remoteValidationResultPassword = await validateRemotePassword();
                const inputPassword = $("#inputPassword");
                const accessErrorPassword = $("#accessErrorPassword");
                if (!remoteValidationResultPassword.valid) {
                    // Remote validation failed, display the error message
                    accessErrorPassword.addClass('invalid-feedback');
                    inputPassword.addClass('is-invalid');

                    accessErrorPassword.text(remoteValidationResultPassword
                        .errorMessage); // Set the error message from the response
                    indicatorNone();

                    return;
                } else {
                    accessErrorPassword.removeClass('invalid-feedback');
                    inputPassword.removeClass('is-invalid');
                    accessErrorPassword.text('');
                }

                // Validate the form using Parsley
                if ($(form).parsley().validate()) {
                    indicatorSubmit();
                    // Submit the form
                    form.submit();
                } else {
                    // Handle validation errors
                    const validationErrors = [];
                    $(form).find(':input').each(function() {
                        indicatorNone();

                        const field = $(this);
                        if (!field.parsley().isValid()) {
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

            async function validateRemotePassword() {
                const inputEmail = $('#inputEmail');
                const inputPassword = $('#inputPassword');
                const remoteValidationUrl = "{{ route('admin.login.checkPassword') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            email: inputEmail.val(),
                            password: inputPassword.val()
                        }
                    });

                    // Assuming the response is JSON and contains a "valid" key
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

            async function validateRemoteEmail() {
                const inputEmail = $('#inputEmail');
                const remoteValidationUrl = "{{ route('admin.login.checkEmail') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            email: inputEmail.val()
                        }
                    });

                    // Assuming the response is JSON and contains a "valid" key
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
