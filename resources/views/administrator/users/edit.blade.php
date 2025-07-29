@extends('administrator.layouts.main')

@section('content')
@push('section_header')
        <h1>Users</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.users') }}">Users</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    @endpush
    @push('section_title')
        User
    @endpush
    <!-- Basic Tables start -->
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('admin.users.update') }}" method="post" enctype="multipart/form-data"
                        class="form" id="form" data-parsley-validate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="inputId" name="user_id" value="{{ $data->user_id }}">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                    <label for="userGroupField" class="form-label">User Group</label>
                                    <select class="form-control" name="user_group" id="userGroupField"
                                        data-parsley-required="true">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                    <label for="nameField" class="form-label">Nama</label>
                                    <input type="text" id="nameField" class="form-control" placeholder="Enter Nama"
                                        value="{{ $data->name }}" name="name" autocomplete="off"
                                        data-parsley-required="true">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                    <label for="emailField" class="form-label">Email</label>
                                    <input type="text" id="emailField" class="form-control" placeholder="Enter Email"
                                        value="{{ $data->email }}" name="email" autocomplete="off"
                                        data-parsley-required="true">
                                    <div class="" style="color: #dc3545" id="accessErrorEmail"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                    <label for="codeField" class="form-label">Code</label>
                                    <div class="row">
                                        <div class="col-8">
                                            <input type="text" id="codeField" class="form-control"
                                                placeholder="Enter Code" name="id" autocomplete="off"
                                                data-parsley-required="true" value="{{ $data->id }}">
                                            <div class="" style="color: #dc3545" id="accessErrorCode"></div>
                                        </div>
                                        <div class="col-2">
                                            <a href="javascript:void(0)" class="btn btn-primary"
                                                id="buttonGenerateCode"><span class="indicator-label-code">Generate</span>
                                                <span class="indicator-progress-code" style="display: none;">
                                                    <div class="d-flex">
                                                        Generate...
                                                        <span
                                                            class="spinner-border spinner-border-sm align-middle ms-2 mt-1"></span>
                                                    </div>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                    <label for="passwordField" class="form-label">Password</label>
                                    <input type="text" id="passwordField" class="form-control"
                                        placeholder="Enter Password" name="password" autocomplete="off">
                                    <div class="" style="color: #dc3545" id="accessErrorPasssword"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                    <label for="konfirmasiPasswordField" class="form-label">Confirmation Password</label>
                                    <input type="text" id="konfirmasiPasswordField" class="form-control"
                                        placeholder="Enter Confirmation Password" name="konfirmasi_password"
                                        autocomplete="off">
                                    <div class="" style="color: #dc3545" id="accessErrorConfirmationPasssword"></div>
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
                                            <input class="form-check-input" type="radio" name="status"
                                                id="flexRadioDefault1" {{ $data->status ? 'checked' : '' }}
                                                value="1">
                                            <label class="form-check-label form-label" for="flexRadioDefault1">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status"
                                                id="flexRadioDefault2" {{ !$data->status ? 'checked' : '' }}
                                                value="0">
                                            <label class="form-check-label form-label" for="flexRadioDefault2">
                                                Not Active
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
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                <a href="{{ route('admin.users') }}" class="btn btn-danger me-1 mb-1">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Basic Tables end -->
@endsection



@push('js')
    <script src="{{ asset('templateAdmin/assets/extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('templateAdmin/assets/js/pages/parsley.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Add an event listener to the "Generate" button
            const generateCodeButton = document.getElementById("buttonGenerateCode");
            const codeField = document.getElementById("codeField");
            const indicatorLabelCode = document.querySelector(".indicator-label-code");
            const indicatorProgressCode = document.querySelector(".indicator-progress-code");
            const remoteGenerateCodeUrl = "{{ route('admin.users.generateCode') }}";

            generateCodeButton.addEventListener("click", async function() {
                // Show the indicator when the button is clicked
                indicatorLabelCode.style.display = "none";
                indicatorProgressCode.style.display = "inline-block";

                // Make an AJAX request to generate the code
                try {
                    const response = await $.ajax({
                        method: "GET",
                        url: remoteGenerateCodeUrl,
                    });

                    // Assuming the response is JSON and contains a "generateCode" key
                    codeField.value = response.generateCode;
                } catch (error) {
                    console.error("Generate error:", error);
                    // Handle errors as needed
                } finally {
                    // Hide the indicator when the AJAX request is complete
                    indicatorLabelCode.style.display = "inline-block";
                    indicatorProgressCode.style.display = "none";
                }
            });



            //validate parsley form
            const form = document.getElementById("form");
            const validator = $(form).parsley();

            const submitButton = document.getElementById("formSubmit");

            form.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });

            submitButton.addEventListener("click", async function(e) {
                e.preventDefault();

                // Perform remote validation
                const remoteValidationResult = await validateRemoteEmail();
                const emailField = $("#emailField");
                const accessErrorEmail = $("#accessErrorEmail");
                if (!remoteValidationResult.valid) {
                    // Remote validation failed, display the error message
                    accessErrorEmail.addClass('invalid-feedback');
                    emailField.addClass('is-invalid');

                    accessErrorEmail.text(remoteValidationResult
                        .errorMessage); // Set the error message from the response

                    return;
                } else {
                    accessErrorEmail.removeClass('invalid-feedback');
                    emailField.removeClass('is-invalid');
                    accessErrorEmail.text('');
                }

                const remoteValidationResultCode = await validateRemoteCode();
                const codeField = $("#codeField");
                const accessErrorCode = $("#accessErrorCode");
                if (!remoteValidationResultCode.valid) {
                    // Remote validation failed, display the error message
                    accessErrorCode.addClass('invalid-feedback');
                    codeField.addClass('is-invalid');

                    accessErrorCode.text(remoteValidationResultCode
                        .errorMessage); // Set the error message from the response

                    return;
                } else {
                    accessErrorCode.removeClass('invalid-feedback');
                    codeField.removeClass('is-invalid');
                    accessErrorCode.text('');
                }

                const inputId = $('#inputId').val();
                if (inputId !== 1) {
                    // Get the value from the code field
                    const codeValue = codeField.val().trim();
    
                    // Validate the length and format of the code
                    if (codeValue.length !== 12 || !codeValue.startsWith('webits-') || codeValue.substring(
                            7).length !== 5) {
                        accessErrorCode.addClass('invalid-feedback');
                        codeField.addClass('is-invalid');
    
                        accessErrorCode.text('Code harus 12 characters dan diawali dengan webits- lalu diakhiri oleh 5 uniqid.');
                        return;
                    } else {
                        accessErrorCode.removeClass('invalid-feedback');
                        codeField.removeClass('is-invalid');
                        accessErrorCode.text('');
                    }
                }

                const passwordField = $('#passwordField').val().trim();

                if (passwordField !== '') {
                    if (!validatePasswordConfirmation()) {
                        return;
                    }
                }



                // Validate the form using Parsley
                if ($(form).parsley().validate()) {
                    // Disable the submit button and show the "Please wait..." message
                    submitButton.querySelector('.indicator-label').style.display = 'none';
                    submitButton.querySelector('.indicator-progress').style.display =
                        'inline-block';

                    // Perform your asynchronous form submission here
                    // Simulating a 2-second delay for demonstration
                    setTimeout(function() {
                        // Re-enable the submit button and hide the "Please wait..." message
                        submitButton.querySelector('.indicator-label').style.display =
                            'inline-block';
                        submitButton.querySelector('.indicator-progress').style.display =
                            'none';

                        // Submit the form
                        form.submit();
                    }, 2000);
                } else {
                    // Handle validation errors
                    const validationErrors = [];
                    $(form).find(':input').each(function() {
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

            async function validateRemoteEmail() {
                const emailInput = $('#emailField');
                const inputId = $('#inputId');
                const remoteValidationUrl = "{{ route('admin.users.checkEmail') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            email: emailInput.val(),
                            id: inputId.val()
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

            async function validateRemoteCode() {
                const codeInput = $('#codeField');
                const inputId = $('#inputId');
                const remoteValidationUrl = "{{ route('admin.users.checkCode') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            code: codeInput.val(),
                            id: inputId.val()
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

            $('#passwordField, #konfirmasiPasswordField').on('input', function() {
                if ($('#passwordField').val().trim() !== '') {
                    validatePasswordConfirmation();
                } else {
                    // Clear validation messages when password field is empty
                    $('#passwordField').removeClass('is-invalid');
                    $('#accessErrorPasssword').text('');
                    $('#konfirmasiPasswordField').removeClass('is-invalid');
                    $('#accessErrorConfirmationPasssword').text('');
                    return true;
                }
            });

            function validatePasswordConfirmation() {
                const passwordField = $('#passwordField');
                const accessErrorPassword = $("#accessErrorPasssword");
                const konfirmasiPasswordField = $('#konfirmasiPasswordField');
                const accessErrorConfirmationPassword = $("#accessErrorConfirmationPasssword");

                if (passwordField.val().length < 8) {
                    passwordField.addClass('is-invalid');
                    accessErrorPassword.text('Password harus memiliki setidaknya 8 karakter');
                    return false;
                } else if (passwordField.val() !== konfirmasiPasswordField.val()) {
                    passwordField.removeClass('is-invalid');
                    accessErrorPassword.text('');
                    konfirmasiPasswordField.addClass('is-invalid');
                    accessErrorConfirmationPassword.text('Confirmation Password harus sama dengan Password');
                    return false;
                } else {
                    passwordField.removeClass('is-invalid');
                    accessErrorPassword.text('');
                    konfirmasiPasswordField.removeClass('is-invalid');
                    accessErrorConfirmationPassword.text('');
                    return true;
                }
            }



            var optionUserGroup = $('#userGroupField');


            optionUserGroup.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Loading...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show();

            $.ajax({
                url: '{{ route('admin.users.getUserGroup') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.usergroup;
                    var optionsHtml = ''; // Store the generated option elements

                    // Iterate through each user group in the response data
                    for (var i = 0; i < data.length; i++) {
                        var userGroup = data[i];
                        optionsHtml += '<option value="' + userGroup.id + '">' + userGroup
                            .name + '</option>';
                    }

                    // Construct the final dropdown HTML
                    var finalDropdownHtml = optionsHtml;

                    optionUserGroup.html(finalDropdownHtml);

                    loadingSpinner.hide(); // Hide the loading spinner after data is loaded

                    // Set the selected option based on the value of $data->id
                    if ('{{ $data->user_group }}') {
                        optionUserGroup.val('{{ $data->user_group->id ?? '' }}');
                    } else {
                        optionUserGroup.prepend('<option value="" selected>Choose Data</option>');
                    }
                },
                error: function() {
                    // Handle the error case if the AJAX request fails
                    console.error('Gagal memuat data User Group.');
                    optionUserGroup.html('<option>Gagal memuat data</option>')
                    loadingSpinner
                        .hide(); // Hide the loading spinner even if there's an error
                }
            });

        });
    </script>
@endpush
