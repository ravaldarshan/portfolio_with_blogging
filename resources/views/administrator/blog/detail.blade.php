@extends('administrator.layouts.main')

@push('css')
    <style>
        .data_disabled {
            background-color: #aba8a8 !important;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    @push('section_header')
        <h1>Blog</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.blog') }}">Blog</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    @endpush
    @push('section_title')
        Blog
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.blog.update') }}" method="post" enctype="multipart/form-data" class="form"
                    id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="inputId" value="{{ $data->id }}">

                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="inputKategoriProjectName" class="form-label">Kategori</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputKategoriProjectName"
                                        value="{{ $data->kategori->nama }}" readonly>
                                    <div class="input-group-append">
                                        <a href="#" class="btn btn-secondary data_disabled" data-toggle="modal"
                                            data-target="#modalKategoriProject" disabled>
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </div>
                                    <input type="text" class="d-none" name="kategori" id="inputKategoriProject"
                                        value="{{ $data->kategori->id }}" data-parsley-required="true"
                                        aria-labelledby="inputKategoriProjectNameLabel">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputTanggalPosting" class="form-label">Tanggal Posting</label>
                                <input type="text" id="inputTanggalPosting" class="form-control"
                                    value="{{ date('d-m-Y', strtotime($data->tanggal_posting)) }}"
                                    placeholder="Pilih Tanggal Posting" name="tanggal_posting" autocomplete="off"
                                    data-parsley-required="true" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputJudul" class="form-label">Judul</label>
                                <input type="text" id="inputJudul" class="form-control" placeholder="Masukan Judul"
                                    value="{{ $data->judul }}" name="judul" autocomplete="off"
                                    data-parsley-required="true" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="gambarLainnyaInputFile" class="form-label">Gambar Lainnya</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview-gambar_lainnya thumbnail mb20">
                                        <!-- Tampilkan preview gambar-gambar yang diunggah di sini -->
                                        @if (!empty($decodeImg))
                                            @foreach ($decodeImg as $img)
                                                <div class="img-thumbnail-container" id="{{ $img }}"><img
                                                        class="img-thumbnail" width="200"
                                                        src="{{ img_src($img, 'blog') }}"><a
                                                        class="btn btn-secondary btn-sm data_disabled"
                                                        data-img="{{ $img }}"
                                                        data-id="{{ $data->id }}">Hapus</a></div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="mt-3">
                                        <label for="gambarLainnyaInputFile" class="btn btn-light btn-file data_disabled">
                                            <span class="fileinput-new">Select image</span>
                                            <input type="file" class="d-none" id="gambarLainnyaInputFile"
                                                {{ $decodeImg ? '' : 'data-parsley-required="true"' }} name="img[]"
                                                multiple>
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
                                <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                                {!! $data->isi !!}
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
                                        <input class="form-check-input" type="radio" name="status" disabled
                                            id="flexRadioDefault1" {{ $data->status ? 'checked' : '' }} value="1">
                                        <label class="form-check-label form-label" for="flexRadioDefault1">
                                            Public
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" disabled
                                            id="flexRadioDefault2" {{ !$data->status ? 'checked' : '' }} value="0">
                                        <label class="form-check-label form-label" for="flexRadioDefault2">
                                            Private
                                        </label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('admin.blog') }}" class="btn btn-danger me-1 mb-1">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- @include('administrator.blog.modal.kategori_project') --}}
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
                title: 'Apakah anda yakin ingin menghapus image ini',
                icon: 'warning',
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Ya, Saya yakin!',
                cancelButtonText: 'Tidak, Batalkan!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.blog.deleteImage') }}",
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

        // Fungsi untuk menangani perubahan pada file input
        function handleFileInputChange() {
            const newInput = this; // 'this' mengacu pada elemen file input yang dipicu oleh perubahan

            // Mendapatkan file yang baru dipilih
            const newFiles = newInput.files;

            // Lakukan sesuatu dengan file yang baru dipilih
            for (let i = 0; i < newFiles.length; i++) {
                const newFile = newFiles[i];

                // Lakukan sesuatu dengan setiap file, misalnya, tampilkan informasi di konsol
                console.log(`File Baru: ${newFile.name}, Tipe: ${newFile.type}, Ukuran: ${newFile.size} bytes`);
            }

            // Anda dapat menambahkan logika lain sesuai kebutuhan Anda di sini
        }

        // Variabel untuk menyimpan array file
        let filesArray = [];

        const gambarLainnyaInputFile = document.getElementById("gambarLainnyaInputFile");
        const previewContainerGambarLainnya = document.querySelector(".fileinput-preview-gambar_lainnya");

        gambarLainnyaInputFile.addEventListener("change", function() {
            const files = this.files;

            // Loop melalui semua file yang dipilih
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
                img.width = 200; // Sesuaikan ukuran gambar sesuai kebutuhan
                img.src = URL.createObjectURL(file);

                const deleteButton = document.createElement("a");
                deleteButton.classList.add("btn", "btn-danger", "btn-sm", "deleteImg");
                deleteButton.textContent = "Hapus";
                deleteButton.addEventListener("click", function() {

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success mx-4',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    });

                    swalWithBootstrapButtons.fire({
                        title: 'Apakah anda yakin ingin menghapus image ini',
                        icon: 'warning',
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Saya yakin!',
                        cancelButtonText: 'Tidak, Batalkan!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {

                            // Hapus gambar saat tombol "Hapus" diklik
                            const fileIndex = filesArray.indexOf(file);
                            if (fileIndex !== -1) {
                                filesArray.splice(fileIndex, 1);

                                // Buat objek DataTransfer baru
                                const newFilesList = new DataTransfer();

                                // Tambahkan file ke objek DataTransfer
                                filesArray.forEach(file => newFilesList.items.add(file));

                                // Set nilai baru untuk file input
                                gambarLainnyaInputFile.files = newFilesList.files;

                                // Tambahkan event listener ke file input baru
                                gambarLainnyaInputFile.addEventListener("change",
                                    handleFileInputChange);
                            }

                            imgContainer.remove();
                        }
                    });
                });

                imgContainer.appendChild(img);
                imgContainer.appendChild(deleteButton);
                previewContainerGambarLainnya.appendChild(imgContainer);

                // Tambahkan file ke dalam array
                filesArray.push(file);
            }
        });
    </script>
@endpush
