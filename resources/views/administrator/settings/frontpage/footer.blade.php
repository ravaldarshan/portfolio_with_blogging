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
                                <input type="text" id="inputFooterText" class="form-control" placeholder="Enter Footer text"
                                    value="{{ array_key_exists('text_frontpage_footer', $settings) ? $settings['text_frontpage_footer'] : '' }}"
                                    name="text_frontpage_footer" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputFooterAbout" class="form-label">About Us</label>
                                <textarea name="about_frontpage_footer" class="form-control" id="inputFooterAbout" placeholder="Enter About Us" cols="30"
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
                                        $link_count = count($link);
                                    }else {
                                        $link_count = 1;
                                    }
                                @endphp
                                <div class="link-list" index-element="{{ $link_count - 1 }}">
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
                                                        placeholder="Enter Social Media Name" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-11">
                                                <div class="form-group">
                                                    <label for="inputLinkUrl_{{ $i }}"
                                                        class="form-label">Url</label>
                                                    <input type="text" name="url_link_{{ $i }}"
                                                        value="{{ $row->url_link }}" class="form-control"
                                                        id="inputLinkUrl_{{ $i }}" data-parsley-required="true"
                                                        placeholder="Enter Social Media Icons (contoh 'fa fa-instagram')" autocomplete="off">
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
                                <input type="hidden" name="link_count" value="{{ $link_count }}" id="link_count">
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
                                    Wait a moment...
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
                    placeholder="Enter Nama Sosial Media" autocomplete="off">
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
                
                var currentIndex = $(".link-list").find('.row').length;
                $('#link_count').val((currentIndex + 1));

                
                var clonedElement = $(".template-link").clone();
                clonedElement.addClass("row rowLink_" + currentIndex);
                clonedElement.removeClass("template-link");
                clonedElement.removeClass("d-none");

                
                clonedElement.attr("index-element", currentIndex);

                
                clonedElement.find("[id^='inputNamaLink_']").attr("id", "inputNamaLink_" + currentIndex);
                clonedElement.find("[id^='inputLinkUrl_']").attr("id", "inputLinkUrl_" +
                    currentIndex);

                clonedElement.find("[for^='inputNamaLink_']").attr("for", "inputNamaLink_" + currentIndex);
                clonedElement.find("[for^='inputLinkUrl_']").attr("for", "inputLinkUrl_" +
                    currentIndex);

                
                clonedElement.find("[name^='nama_link_']").attr("name", "nama_link_" + currentIndex);
                clonedElement.find("[name^='url_link_']").attr("name", "url_link_" + currentIndex);

                clonedElement.find(".delete-link").attr("data-index", currentIndex);

                
                $(".link-list").append(clonedElement);

                
                $(".link-list .delete-link").show();
                $(".link-list .rowLink_0 .delete-link").hide();
            }

            
            function deleteLinkList(element, index) {
                var linkList = $(element).find(".rowLink_" + index);

                
                if (linkList.attr("index-element") !== "0") {
                    linkList.remove();
                    const jmlah = parseInt($('#link_count').val()) - 1;
                    $('#link_count').val(jmlah);
                }
            }

            
            $(".more-link").click(function() {
                addLinkList();
            });

            
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
                    title: 'Are you sure you want to delete this data??',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, I am sure!',
                    cancelButtonText: 'No, Cancel!',
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
                                    "index": index, 
                                    "link": link, 
                                },
                                success: function() {
                                    deleteLinkList(linkList, index);
                                    swalWithBootstrapButtons.fire({
                                        title: 'Succeed!',
                                        text: 'Data deleted successfully.',
                                        icon: 'success',
                                        timer: 1500, 
                                        showConfirmButton: false,
                                    });
                                }
                            });
                        } else {
                            deleteLinkList(linkList, index);
                            swalWithBootstrapButtons.fire({
                                title: 'Succeed!',
                                text: 'Data deleted successfully.',
                                icon: 'success',
                                timer: 1500, 
                                showConfirmButton: false,
                            });
                        }
                    }
                });
            });

            
            $(".link-list[index-element='0'] .delete-link").hide();
        });
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
