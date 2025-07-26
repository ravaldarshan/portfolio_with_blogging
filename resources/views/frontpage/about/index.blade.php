@extends('frontpage.layouts.main')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg-color" data-setbgcolor="{{ $settings['general_breadcrumb_color'] ?? '#1e2a45' }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>About us</h2>
                        <div class="breadcrumb__links">
                            <a href="{{route('web.index')}}">Home</a>
                            <span>About</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- About Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about__pic">
                        <div class="row" id="gallerySection">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="about__pic__item about__pic__item--large set-bg"
                                    data-setbg="http://placehold.it/500x500?text=Not Found"></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="about__pic__item set-bg"
                                            data-setbg="http://placehold.it/500x500?text=Not Found"></div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="about__pic__item set-bg"
                                            data-setbg="http://placehold.it/500x500?text=Not Found"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__text">
                        <div class="section-title">
                            <span>About Me</span>
                            <h2>WHO I AM?</h2>
                        </div>
                        <div class="row" id="serviceSection">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="services__item">
                                    <div class="services__item__icon">
                                        <img src="http://placehold.it/500x500?text=Not Found" alt="">
                                    </div>
                                    <h4>Web Developer</h4>
                                    <p>Whether you’re halfway through the editing process, or you.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="services__item">
                                    <div class="services__item__icon">
                                        <img src="http://placehold.it/500x500?text=Not Found" alt="">
                                    </div>
                                    <h4>Backend Developer</h4>
                                    <p>Whether you’re halfway through the editing process, or you.</p>
                                </div>
                            </div>
                        </div>
                        <div class="about__text__desc" id="descriptionSection">
                            <p>Formed in 2006 by Matt Hobbs and Cael Jones, Videoprah is an award-winning, full-service
                                production company specializing in commercial, broadcast, tourism & action sport video
                                production services has been featured.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->
@endsection

@push('js')
    <script type="text/javascript">
        //Service
        $.ajax({
            type: "GET",
            url: "{{ route('web.about.getService') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": "GET",
            },
            success: function(respon) {
                let serviceHtml = ''

                for (let i = 0; i < respon.data.length; i++) {
                    const data = respon.data[i];

                    let serviceJsonDecode = JSON.parse(data.value);
                    serviceHtml += `<div class="col-lg-6 col-md-6 col-sm-6">` +
                        `<div class="services__item">` +
                        `<div class="services__item__icon">` +
                        `<img src="{{ asset('administrator/assets/media/service') }}/` +
                        serviceJsonDecode.img_url + `" alt="">` +
                        `</div>` +
                        `<h4>` + serviceJsonDecode.title + `</h4>` +
                        `<p>` + serviceJsonDecode.body + `</p>` +
                        `</div>` +
                        `</div>`;
                }
                $('#serviceSection').html(
                    serviceHtml
                )
            }
        });

        //About
        $.ajax({
            type: "GET",
            url: "{{ route('web.about.getAbout') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": "GET",
            },
            success: function(respon) {
                const datas = respon.data;
                let DeskripsiHtml = ''
                let imgJson = ''
                let imgHtml = ''

                for (let index = 0; index < datas.length; index++) {
                    const data = datas[index];
                    if (data.name === 'deskripsi') {
                        DeskripsiHtml += `<p>` + data.value + `</p>`
                    } else if (data.name === 'image') {
                        imgJson += data.value;
                    }
                }
                $('#descriptionSection').html(
                    DeskripsiHtml
                )

                const imgParse = JSON.parse(imgJson);
                for (let i = 0; i < imgParse.length; i++) {
                    const img_url = imgParse[i];

                    if (i === 0) {
                        imgHtml += `<div class="col-lg-6 col-md-6 col-sm-6">` +
                            `<div class="about__pic__item about__pic__item--large set-bg" data-setbg="{{ asset_administrator('assets/media/gallery') }}/${img_url}"></div>` +
                            `</div>`;
                    } else {
                        if (i % 2 !== 0) {
                            imgHtml += `<div class="col-lg-6 col-md-6 col-sm-6">` +
                                `<div class="row">` +
                                `<div class="col-lg-12">` +
                                `<div class="about__pic__item set-bg" data-setbg="{{ asset_administrator('assets/media/gallery') }}/${img_url}"></div>` +
                                `</div>`;
                        } else {
                            imgHtml += `<div class="col-lg-12">` +
                                `<div class="about__pic__item set-bg" data-setbg="{{ asset_administrator('assets/media/gallery') }}/${img_url}"></div>` +
                                `</div>` +
                                `</div>` +
                                `</div>`;
                        }
                    }
                }

                $('#gallerySection').html(
                    imgHtml
                )

                $('.set-bg').each(function() {
                    var bg = $(this).data('setbg');
                    $(this).css('background-image', 'url(' + bg + ')');
                });
            }
        });
    </script>
@endpush
