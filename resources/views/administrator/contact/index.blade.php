@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Contact</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Contact</div>
        </div>
    @endpush
    @push('section_title')
        Setting Contact
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.contact.update') }}" method="post" enctype="multipart/form-data"
                    class="form" id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputAddress" class="form-label">Address</label>
                                <input type="text" id="inputAddress" class="form-control" placeholder="Masukan Address"
                                    value="{{ array_key_exists('address', $data) ? $data['address'] : '' }}"
                                    name="address" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputTelepon" class="form-label">No Telepon</label>
                                <input type="text" id="inputTelepon" class="form-control" placeholder="Masukan Nomor Telepon"
                                    value="{{ array_key_exists('telepon', $data) ? $data['telepon'] : '' }}"
                                    name="telepon" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputEmail" class="form-label">Email</label>
                                <input type="text" id="inputEmail" class="form-control" placeholder="Masukan Footer text"
                                    value="{{ array_key_exists('email', $data) ? $data['email'] : '' }}"
                                    name="email" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="inputLocation" class="form-label">Location <mark>Iframe g-map</mark></label>
                                <textarea name="location" class="form-control" id="inputLocation" placeholder="Masukan Location Google Map" cols="30"
                                    rows="100" autocomplete="off" data-parsley-required="true">{{ array_key_exists('location', $data) ? $data['location'] : '' }}</textarea>
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
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Tambahkan FileInput JavaScript -->
    <script src="{{ asset_administrator('assets/plugins/form-jasnyupload/fileinput.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            //validate parsley form
            const form = document.getElementById("form");
            const validator = $(form).parsley();

            const submitButton = document.getElementById("formSubmit");

            submitButton.addEventListener("click", async function(e) {
                e.preventDefault();

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

        });
    </script>
@endpush
