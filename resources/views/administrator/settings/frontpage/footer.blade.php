@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Settings</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">Settings</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.settings.frontpage') }}">Frontpage</a></div>
            <div class="breadcrumb-item">Footer</div>
        </div>
    @endpush
    @push('section_title')
        Setting Footer
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.settings.frontpage.footer.update') }}" method="post" enctype="multipart/form-data"
                    class="form" id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputFooterText" class="form-label">Footer</label>
                                <input type="text" id="inputFooterText" class="form-control" placeholder="Masukan Footer text"
                                    value="{{ array_key_exists('text_frontpage_footer', $settings) ? $settings['text_frontpage_footer'] : '' }}"
                                    name="text_frontpage_footer" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputFooterAbout" class="form-label">About Us</label>
                                <textarea name="about_frontpage_footer" class="form-control" id="inputFooterAbout" placeholder="Masukan About Us" cols="30"
                                    rows="100" autocomplete="off" data-parsley-required="true">{{ array_key_exists('about_frontpage_footer', $settings) ? $settings['about_frontpage_footer'] : '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 col-12">
                            <div id="link">
                                @php
                                    $link = array_key_exists('link_frontpage_footer', $settings) ? json_decode($settings['link_frontpage_footer']) : '';
                                    if (!empty($link)) {
                                        $jumlah_link = count($link);
                                    }else {
                                        $jumlah_link = 1;
                                    }
                                @endphp
                                <div class="link-list" index-element="{{ $jumlah_link - 1 }}">
                                    @if (!empty($link))
                                    @foreach ($link as $i => $row)
                                        <div class="row rowLink_{{ $i }}">
                                            {{-- {{dd($link)}} --}}
                                            <div class="col-md-5 col-11">
                                                <div class="form-group">
                                                    <label for="inputNamaLink_{{ $i }}"
                                                        class="form-label">Nama Link</label>
                                                    <input type="text" name="nama_link_{{ $i }}"
                                                        value="{{ $row->nama_link }}" class="form-control"
                                                        id="inputNamaLink_{{ $i }}" data-parsley-required="true"
                                                        placeholder="Masukan Nama Sosial Media" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-11">
                                                <div class="form-group">
                                                    <label for="inputLinkUrl_{{ $i }}"
                                                        class="form-label">Url</label>
                                                    <input type="text" name="url_link_{{ $i }}"
                                                        value="{{ $row->url_link }}" class="form-control"
                                                        id="inputLinkUrl_{{ $i }}" data-parsley-required="true"
                                                        placeholder="Masukan Icon Sosial Media (contoh 'fa fa-instagram')" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-1">
                                                <button class="btn btn-danger btn-sm delete-link"
                                                    @if ($i === 0) style="display: none" @endif
                                                    data-link="{{$row->nama_link}}" data-index="{{ $i }}" type="button"><i
                                                        class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endif
                                </div>
                                <input type="hidden" name="jumlah_link" value="{{ $jumlah_link }}" id="jumlah_link">
                                <!-- Cloned link-list will be inserted here -->
                            </div>
                            <button class="more-link btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i> Add
                                more link</button>
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

    <div class="template-link d-none">
        <div class="col-md-5 col-11">
            <div class="form-group">
                <label for="inputNamaLink_0" class="form-label">Nama Link</label>
                <input type="text" name="nama_link_0" class="form-control" id="inputNamaLink_0" data-parsley-required="true"
                    placeholder="Masukan Nama Sosial Media" autocomplete="off">
            </div>
        </div>
        <div class="col-md-6 col-11">
            <div class="form-group">
                <label for="inputLinkUrl_0" class="form-label">Url Link</label>
                <input type="text" name="url_link_0" class="form-control" id="inputLinkUrl_0" data-parsley-required="true"
                    placeholder="contoh = 'fa fa-instagram'" autocomplete="off">
            </div>
        </div>
        <div class="col-md-1 col-1">
            <button class="btn btn-danger btn-sm delete-link" style="display: none" data-index="0" data-link=""
                type="button"><i class="fa fa-trash"></i></button>
        </div>
    </div>
    <!-- Basic Tables end -->
@endsection

@push('js')
    <!-- Tambahkan FileInput JavaScript -->
    <script src="{{ asset_administrator('assets/plugins/form-jasnyupload/fileinput.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            function addLinkList() {
                // Use a class selector to get the count of cloned elements
                var currentIndex = $(".link-list").find('.row').length;
                $('#jumlah_link').val((currentIndex + 1));

                // Clone the template-link
                var clonedElement = $(".template-link").clone();
                clonedElement.addClass("row rowLink_" + currentIndex);
                clonedElement.removeClass("template-link");
                clonedElement.removeClass("d-none");

                // Set the index-element attribute on the cloned element
                clonedElement.attr("index-element", currentIndex);

                // Update IDs and "for" attributes of cloned elements
                clonedElement.find("[id^='inputNamaLink_']").attr("id", "inputNamaLink_" + currentIndex);
                clonedElement.find("[id^='inputLinkUrl_']").attr("id", "inputLinkUrl_" +
                    currentIndex);

                clonedElement.find("[for^='inputNamaLink_']").attr("for", "inputNamaLink_" + currentIndex);
                clonedElement.find("[for^='inputLinkUrl_']").attr("for", "inputLinkUrl_" +
                    currentIndex);

                // Update name attributes of cloned input elements
                clonedElement.find("[name^='nama_link_']").attr("name", "nama_link_" + currentIndex);
                clonedElement.find("[name^='url_link_']").attr("name", "url_link_" + currentIndex);

                clonedElement.find(".delete-link").attr("data-index", currentIndex);

                // Append the cloned element to the container
                $(".link-list").append(clonedElement);

                // Show delete button for the new row, hide for the initial row
                $(".link-list .delete-link").show();
                $(".link-list .rowLink_0 .delete-link").hide();
            }

            // Function to handle deleting link-list
            function deleteLinkList(element, index) {
                var linkList = $(element).find(".rowLink_" + index);

                // Check if it is not the first row before deleting
                if (linkList.attr("index-element") !== "0") {
                    linkList.remove();
                    const jmlah = parseInt($('#jumlah_link').val()) - 1;
                    $('#jumlah_link').val(jmlah);
                }
            }

            // Event listener for "Add more link" button
            $(".more-link").click(function() {
                addLinkList();
            });

            // Event listener for "Delete" button
            $("#link").on("click", ".delete-link", function() {
                let index = $(this).data('index');
                let link = $(this).data('link');
                let linkList = $(this).closest(".link-list");

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Saya yakin!',
                    cancelButtonText: 'Tidak, Batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (link !== '') {
                            $.ajax({
                                type: "GET",
                                url: "{{ route('admin.settings.frontpage.footer.deleteLink') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "_method": "GET",
                                    "index": index, // Make sure you define the variable 'id' to be deleted
                                    "link": link, // Make sure you define the variable 'id' to be deleted
                                },
                                success: function() {
                                    deleteLinkList(linkList, index);
                                    swalWithBootstrapButtons.fire({
                                        title: 'Berhasil!',
                                        text: 'Data berhasil dihapus.',
                                        icon: 'success',
                                        timer: 1500, // 2 detik
                                        showConfirmButton: false,
                                    });
                                }
                            });
                        } else {
                            deleteLinkList(linkList, index);
                            swalWithBootstrapButtons.fire({
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success',
                                timer: 1500, // 2 detik
                                showConfirmButton: false,
                            });
                        }
                    }
                });
            });

            // Hide delete button for the initial row
            $(".link-list[index-element='0'] .delete-link").hide();
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

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
