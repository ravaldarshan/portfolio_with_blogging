@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Modules</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.module') }}">Modules</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    @endpush
    @push('section_title')
        Module
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.module.update') }}" method="post" enctype="multipart/form-data" class="form"
                    id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mandatory">
                                        <label for="namaField" class="form-label">Nama</label>
                                        <input type="text" id="namaField" class="form-control" placeholder="Enter Nama"
                                            name="name" autocomplete="off" value="{{ $data->name }}"
                                            data-parsley-required="true">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mandatory">
                                        <label for="identifierField" class="form-label">Identifier</label>
                                        <input type="text" id="identifierField" class="form-control"
                                            placeholder="Enter Identifier" name="identifiers" autocomplete="off"
                                            value="{{ $data->identifiers }}" data-parsley-required="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div id="modul_access">
                                <!-- Assuming $moduleAccessData is an array of module access data from your controller -->
                                @if ($data->access->count() == 0)
                                    <div class="modul_access-list" index-element="0">
                                        <div class="row rowAkses">
                                            <div class="col-md-5 col-11">
                                                <div class="form-group">
                                                    <label class="form-label">Tipe</label>
                                                    <select class="modul_access-tipe form-control"
                                                        data-parsley-required="true" name="modul_access[0][tipe]">
                                                        <option value="">Please Select</option>
                                                        <option value="page">Standard Elements</option>
                                                        <option value="element">Other Elements</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-11">
                                                <div class="form-group code_access-select" style="display: none;">
                                                    <label class="form-label">Access Code</label>
                                                    <select class="modul_access-code_access-select code_access form-control"
                                                        name="modul_access[0][code_access]">
                                                        <option value="">Please Select</option>
                                                        <option value="view">View</option>
                                                        <option value="add">Add</option>
                                                        <option value="edit">Edit</option>
                                                        <option value="delete">Delete</option>
                                                        <option value="detail">Detail</option>
                                                    </select>
                                                </div>
                                                <div class="form-group code_access-input" style="display: none;">
                                                    <label class="form-label">Access Code</label>
                                                    <input class="modul_access-code_access-input code_access form-control" autocomplete="off"
                                                        placeholder="Enter Access Code" name="modul_access[0][code_access]"
                                                        type="text" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @foreach ($data->access as $index => $moduleAccess)
                                        <div class="modul_access-list" index-element="{{ $index }}">
                                            <div class="row rowAkses">
                                                <div class="col-md-5 col-11">
                                                    <div class="form-group">
                                                        <label class="form-label">Tipe</label>
                                                        <select class="modul_access-tipe form-control"
                                                            data-parsley-required="true"
                                                            name="modul_access[{{ $index }}][tipe]">
                                                            <option value="">Please Select</option>
                                                            <option value="page"
                                                                {{ $moduleAccess['identifiers'] == 'view' ||
                                                                $moduleAccess['identifiers'] == 'add' ||
                                                                $moduleAccess['identifiers'] == 'edit' ||
                                                                $moduleAccess['identifiers'] == 'delete' ||
                                                                $moduleAccess['identifiers'] == 'detail'
                                                                    ? 'selected'
                                                                    : '' }}>
                                                                Elemen Standar
                                                            </option>
                                                            <option value="element"
                                                                {{ $moduleAccess['identifiers'] != 'view' &&
                                                                $moduleAccess['identifiers'] != 'add' &&
                                                                $moduleAccess['identifiers'] != 'edit' &&
                                                                $moduleAccess['identifiers'] != 'delete' &&
                                                                $moduleAccess['identifiers'] != 'detail'
                                                                    ? 'selected'
                                                                    : '' }}>
                                                                Other Elements
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-11">
                                                    <div class="form-group code_access-select"
                                                        style="@if (
                                                            $moduleAccess['identifiers'] != 'view' &&
                                                                $moduleAccess['identifiers'] != 'add' &&
                                                                $moduleAccess['identifiers'] != 'edit' &&
                                                                $moduleAccess['identifiers'] != 'delete' &&
                                                                $moduleAccess['identifiers'] != 'detail') display: none; @endif">
                                                        <label class="form-label">Access Code</label>
                                                        <select
                                                            class="modul_access-code_access-select code_access form-control"
                                                            name="modul_access[{{ $index }}][code_access]">
                                                            <option value="">Please Select</option>
                                                            <option value="view"
                                                                {{ $moduleAccess['identifiers'] == 'view' ? 'selected' : '' }}>
                                                                View</option>
                                                            <option value="add"
                                                                {{ $moduleAccess['identifiers'] == 'add' ? 'selected' : '' }}>
                                                                Add</option>
                                                            <option value="edit"
                                                                {{ $moduleAccess['identifiers'] == 'edit' ? 'selected' : '' }}>
                                                                Edit</option>
                                                            <option value="delete"
                                                                {{ $moduleAccess['identifiers'] == 'delete' ? 'selected' : '' }}>
                                                                Delete</option>
                                                            <option value="detail"
                                                                {{ $moduleAccess['identifiers'] == 'detail' ? 'selected' : '' }}>
                                                                Detail</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group code_access-input"
                                                        style="@if (
                                                            $moduleAccess['identifiers'] == 'view' ||
                                                                $moduleAccess['identifiers'] == 'add' ||
                                                                $moduleAccess['identifiers'] == 'edit' ||
                                                                $moduleAccess['identifiers'] == 'delete' ||
                                                                $moduleAccess['identifiers'] == 'detail') display: none; @endif">
                                                        <label class="form-label">Access Code</label>
                                                        <input class="modul_access-code_access-input code_access form-control"
                                                            placeholder="Enter Access Code" autocomplete="off"
                                                            name="modul_access[{{ $index }}][code_access]"
                                                            value="{{ $moduleAccess['identifiers'] }}" type="text" />
                                                    </div>
                                                </div>

                                                @if (!empty($moduleAccess) && $index != 0)
                                                    <div
                                                        class='col-1 deleteRow d-flex align-items-center justify-content-center'>
                                                        <button class='removeData btn btn-primary btn-sm'
                                                            type='button'><i class='fa fa-times'></i></button>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                            <br>
                            <button class="more-access btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i>
                                Add more access</button>

                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" id="formSubmit" class="btn btn-primary mx-1 mb-1">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress" style="display: none;">
                                Wait a moment...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <button type="reset" class="btn btn-secondary mx-1 mb-1">Reset</button>
                        <a href="{{ route('admin.module') }}" class="btn btn-danger mx-1 mb-1">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            $(".more-access").on("click", function() {
                // Clone the first module access element
                var clonning = $(".modul_access-list:first").clone();

                // Clear any errors and values from the cloned element
                clonning.find(".error-block").remove();
                clonning.find(".deleteRow").remove();
                clonning.find(".form-group").removeClass("has-error");
                clonning.find(".modul_access-id").val("");
                clonning.find(".modul_access-tipe").val("");
                clonning.find(".code_access-select").css("display", "none");
                clonning.find(".code_access-input").css("display", "none");
                clonning.find(".modul_access-code_access-input").val("");
                clonning.find(".modul_access-code_access-select").val("");

                // Add a delete button to the cloned element
                clonning.find(".rowAkses").append(
                    "<div class='col-1 deleteRow d-flex align-items-center justify-content-center'>" +
                    "<button class='removeData btn btn-primary btn-sm' type='button'><i class='fa fa-times'></i></button>" +
                    "</div>"
                );

                // Append the cloned element to the form
                $("#modul_access").append(clonning);

                resetData();
            });
            resetData();

            // Menggunakan event delegate untuk mengikuti klik pada tombol "Delete"
            $("#modul_access").on("click", ".removeData", function() {
                var rowToDelete = $(this).closest(".modul_access-list");

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Apakah Anda yakin ingin menghapus baris ini?',
                    text: 'Tindakan ini hanya akan menghapus baris yang ditampilkan, tidak akan menghapus data permanen.',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, I am sure!',
                    cancelButtonText: 'No, Cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Wipe baris dari tampilan
                        deleteRow(rowToDelete);
                        // Tampilkan pesan sukses selama 2 detik dan kemudian otomatis tutup
                        swalWithBootstrapButtons.fire({
                            title: 'Succeed!',
                            text: 'Baris telah dihapus.',
                            icon: 'success',
                            timer: 1500, // 2 detik
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Fungsi untuk menghapus baris
            function deleteRow(element) {
                $(element).remove();
                resetData();
            }


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

        function resetData() {

            var index = 0;
            $(".modul_access-list").each(function() {
                var another = this;
                search_index = $(this).attr("index-element");
                $(this).find('input, select').each(function() {
                    // Ubah nama atribut 'name' dengan pengindeksan yang benar
                    this.name = this.name.replace('[' + search_index + ']', '[' + index + ']');
                    $(another).attr("index-element", index);
                });


                $(this).find(".modul_access-tipe").on("change", function() {
                    $(another).find(".error-block").remove();
                    var tipe = $(this).val();
                    if (tipe == 'element') {
                        // Menampilkan elemen code_access-input
                        $(another).find(".code_access-input").show();
                        // Mengaktifkan validasi pada elemen code_access-input
                        $(another).find(".modul_access-code_access-input").prop("disabled", false);

                        // Menghilangkan elemen code_access-select
                        $(another).find(".code_access-select").hide();
                        // Menonaktifkan validasi pada elemen code_access-select
                        $(another).find(".modul_access-code_access-select").prop("disabled", true);
                        // Menghapus nilai pada elemen code_access-select
                        $(another).find(".modul_access-code_access-select").val("").attr(
                            "data-parsley-required", "false");

                        // Menambahkan validasi pada elemen code_access-input
                        $(another).find(".modul_access-code_access-input").attr("data-parsley-required",
                            "true");
                    } else if (tipe == 'page') {
                        // Menampilkan elemen code_access-select
                        $(another).find(".code_access-select").show();
                        // Mengaktifkan validasi pada elemen code_access-select
                        $(another).find(".modul_access-code_access-select").prop("disabled", false);

                        // Menghilangkan elemen code_access-input
                        $(another).find(".code_access-input").hide();
                        // Menonaktifkan validasi pada elemen code_access-input
                        $(another).find(".modul_access-code_access-input").prop("disabled", true);
                        // Menghapus nilai pada elemen code_access-input
                        $(another).find(".modul_access-code_access-input").val("").attr(
                            "data-parsley-required", "false");

                        // Menambahkan validasi pada elemen code_access-select
                        $(another).find(".modul_access-code_access-select").attr("data-parsley-required",
                            "true");
                    } else if (tipe == '') {
                        // Menghilangkan elemen code_access-select
                        $(another).find(".code_access-select").hide();
                        // Mengaktifkan validasi pada elemen code_access-select
                        $(another).find(".modul_access-code_access-select").prop("disabled", false);
                        // Menghapus nilai pada elemen code_access-select
                        $(another).find(".modul_access-code_access-select").val("").attr(
                            "data-parsley-required", "false");

                        // Menampilkan elemen code_access-input
                        $(another).find(".code_access-input").show();
                        // Mengaktifkan validasi pada elemen code_access-input
                        $(another).find(".modul_access-code_access-input").prop("disabled", false);

                        // Menambahkan validasi pada elemen code_access-input
                        $(another).find(".modul_access-code_access-input").attr("data-parsley-required",
                            "true");
                    }
                });

                index++;
            });
        }
    </script>
@endpush
