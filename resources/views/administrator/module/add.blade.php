@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Modules</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.logSystems') }}">Modules</a></div>
            <div class="breadcrumb-item">Add</div>
        </div>
    @endpush
    @push('section_title')
        Module
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.module.save') }}" method="post" enctype="multipart/form-data" id="form" data-parsley-validate>
                    @csrf
                    @method('POST')
                    <div class="card-header">
                        <h4>Form Add</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mandatory">
                                    <label for="namaField" class="form-label">Nama</label>
                                    <input type="text" id="namaField" class="form-control" placeholder="Masukan Nama"
                                        name="name" autocomplete="off"  data-parsley-required="true">
                                </div>
                                <div class="form-group mandatory">
                                    <label for="identifierField" class="form-label">Identifier</label>
                                    <input type="text" id="identifierField" class="form-control"
                                        placeholder="Masukan Identifier" name="identifiers" autocomplete="off"  data-parsley-required="true">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div id="modul_akses">
                                    <div class="modul_akses-list" index-element="0">
                                        <div class="row rowAkses">
                                            <div class="col-md-5 col-11">
                                                <div class="form-group mandatory">
                                                    <label class="form-label">Tipe</label>
                                                    <select class="modul_akses-tipe form-control" data-parsley-required="true"
                                                         name="modul_akses[0][tipe]">
                                                        <option value="">Please Select</option>
                                                        <option value="page">Elemen Standar</option>
                                                        <option value="element">Elemen Lainnya</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-11">
                                                <div class="form-group kode_akses-select" style="display: none;">
                                                    <label class="form-label">Kode Akses</label>
                                                    <select class="modul_akses-kode_akses-select kode_akses form-control"
                                                        name="modul_akses[0][kode_akses]">
                                                        <option value="">Please Select</option>
                                                        <option value="view">View</option>
                                                        <option value="add">Add</option>
                                                        <option value="edit">Edit</option>
                                                        <option value="delete">Delete</option>
                                                        <option value="detail">Detail</option>
                                                    </select>
                                                </div>
                                                <div class="form-group kode_akses-input" style="display: none;">
                                                    <label class="form-label">Kode Akses</label>
                                                    <input class="modul_akses-kode_akses-input kode_akses form-control"
                                                        placeholder="Masukan Kode Akses" name="modul_akses[0][kode_akses]" autocomplete="off"
                                                        type="text" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button class="more-akses btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i>
                                    Add more akses</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" id="formSubmit" class="btn btn-primary mx-1 mb-1">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress" style="display: none;">
                                Tunggu Sebentar...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <button type="reset" class="btn btn-secondary mx-1 mb-1">Reset</button>
                        <a href="{{route('admin.module')}}" class="btn btn-danger mx-1 mb-1">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            $(".more-akses").on("click", function() {
                var clonning = $(".modul_akses-list:first").clone();
                clonning.find(".error-block").remove();
                clonning.find(".deleteRow").remove();
                clonning.find(".form-group").removeClass("has-error");
                clonning.find(".modul_akses-id").val("");
                clonning.find(".modul_akses-tipe").val("");
                clonning.find(".kode_akses-select").css("display", "none");
                clonning.find(".kode_akses-input").css("display", "none");
                clonning.find(".modul_akses-kode_akses-input").val("");
                clonning.find(".modul_akses-kode_akses-select").val("");
                clonning.find(".rowAkses").append(
                    "<div class='col-1 deleteRow d-flex align-items-center justify-content-center'>" +
                    "<button class='removeData btn btn-primary btn-sm' type='button'><i class='fa fa-times'></i></button>" +
                    "</div>"
                );
                $("#modul_akses").append(clonning);

                resetData();
            });
            resetData();

            // Menggunakan event delegate untuk mengikuti klik pada tombol "Delete"
            $("#modul_akses").on("click", ".removeData", function() {
                var rowToDelete = $(this).closest(".modul_akses-list");

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
                    confirmButtonText: 'Ya, Saya yakin!',
                    cancelButtonText: 'Tidak, Batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Hapus baris dari tampilan
                        deleteRow(rowToDelete);
                        // Tampilkan pesan sukses selama 2 detik dan kemudian otomatis tutup
                        swalWithBootstrapButtons.fire({
                            title: 'Berhasil!',
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
            $(".modul_akses-list").each(function() {
                var another = this;
                search_index = $(this).attr("index-element");
                $(this).find('input, select').each(function() {
                    // Ubah nama atribut 'name' dengan pengindeksan yang benar
                    this.name = this.name.replace('[' + search_index + ']', '[' + index + ']');
                    $(another).attr("index-element", index);
                });


                $(this).find(".modul_akses-tipe").on("change", function() {
                    $(another).find(".error-block").remove();
                    var tipe = $(this).val();
                    if (tipe == 'element') {
                        // Menampilkan elemen kode_akses-input
                        $(another).find(".kode_akses-input").show();
                        // Mengaktifkan validasi pada elemen kode_akses-input
                        $(another).find(".modul_akses-kode_akses-input").prop("disabled", false);

                        // Menghilangkan elemen kode_akses-select
                        $(another).find(".kode_akses-select").hide();
                        // Menonaktifkan validasi pada elemen kode_akses-select
                        $(another).find(".modul_akses-kode_akses-select").prop("disabled", true);
                        // Menghapus nilai pada elemen kode_akses-select
                        $(another).find(".modul_akses-kode_akses-select").val("").attr(
                            "data-parsley-required", "false");

                        // Menambahkan validasi pada elemen kode_akses-input
                        $(another).find(".modul_akses-kode_akses-input").attr("data-parsley-required",
                            "true");
                    } else if (tipe == 'page') {
                        // Menampilkan elemen kode_akses-select
                        $(another).find(".kode_akses-select").show();
                        // Mengaktifkan validasi pada elemen kode_akses-select
                        $(another).find(".modul_akses-kode_akses-select").prop("disabled", false);

                        // Menghilangkan elemen kode_akses-input
                        $(another).find(".kode_akses-input").hide();
                        // Menonaktifkan validasi pada elemen kode_akses-input
                        $(another).find(".modul_akses-kode_akses-input").prop("disabled", true);
                        // Menghapus nilai pada elemen kode_akses-input
                        $(another).find(".modul_akses-kode_akses-input").val("").attr(
                            "data-parsley-required", "false");

                        // Menambahkan validasi pada elemen kode_akses-select
                        $(another).find(".modul_akses-kode_akses-select").attr("data-parsley-required",
                            "true");
                    } else if (tipe == '') {
                        // Menghilangkan elemen kode_akses-select
                        $(another).find(".kode_akses-select").hide();
                        // Mengaktifkan validasi pada elemen kode_akses-select
                        $(another).find(".modul_akses-kode_akses-select").prop("disabled", false);
                        // Menghapus nilai pada elemen kode_akses-select
                        $(another).find(".modul_akses-kode_akses-select").val("").attr(
                            "data-parsley-required", "false");

                        // Menampilkan elemen kode_akses-input
                        $(another).find(".kode_akses-input").show();
                        // Mengaktifkan validasi pada elemen kode_akses-input
                        $(another).find(".modul_akses-kode_akses-input").prop("disabled", false);

                        // Menambahkan validasi pada elemen kode_akses-input
                        $(another).find(".modul_akses-kode_akses-input").attr("data-parsley-required",
                            "true");
                    }
                });

                index++;
            });
        }
    </script>
@endpush
