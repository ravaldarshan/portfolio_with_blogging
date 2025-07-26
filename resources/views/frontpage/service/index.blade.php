@extends('frontpage.layouts.main')
@push('css')
    <style>
        /* Set a fixed height for the container */
        .logo__item {
            height: 150px;
            /* Adjust the height as needed */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Set a max-width for the images to maintain their original aspect ratio */
        .client-logo {
            max-width: 100%;
            /* Ensure the image doesn't exceed the container width */
            max-height: 100%;
            /* Ensure the image doesn't exceed the container height */
        }
    </style>
@endpush
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg-color" data-setbgcolor="{{ $settings['general_breadcrumb_color'] ?? '#1e2a45' }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Our Sevices</h2>
                        <div class="breadcrumb__links">
                            <a href="{{ route('web.index') }}">Home</a>
                            <span>Services</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Services Section Begin -->
    <section class="services-page spad">
        <div class="container">
            <div class="row" id="serviceSection">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="services__item">
                        <div class="services__item__icon">
                            <img src="{{ template_frontpage('img/icons/si-2.png') }}" alt="">
                        </div>
                        <h4>Scriptwriting and editing</h4>
                        <p>Whether you’re halfway through the editing process, or you haven’t even started, our post
                            production services can put the finishing touches.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="services__item">
                        <div class="services__item__icon">
                            <img src="{{ template_frontpage('img/icons/si-1.png') }}" alt="">
                        </div>
                        <h4>Motion graphics</h4>
                        <p>Whether you’re halfway through the editing process, or you haven’t even started, our post
                            production services can put the finishing touches.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="services__item">
                        <div class="services__item__icon">
                            <img src="{{ template_frontpage('img/icons/si-2.png') }}" alt="">
                        </div>
                        <h4>Scriptwriting and editing</h4>
                        <p>Whether you’re halfway through the editing process, or you haven’t even started, our post
                            production services can put the finishing touches.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="services__item">
                        <div class="services__item__icon">
                            <img src="{{ template_frontpage('img/icons/si-3.png') }}" alt="">
                        </div>
                        <h4>Video distribution</h4>
                        <p>Whether you’re halfway through the editing process, or you haven’t even started, our post
                            production services can put the finishing touches.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="services__item">
                        <div class="services__item__icon">
                            <img src="{{ template_frontpage('img/icons/si-4.png') }}" alt="">
                        </div>
                        <h4>Video hosting</h4>
                        <p>Whether you’re halfway through the editing process, or you haven’t even started, our post
                            production services can put the finishing touches.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="services__item">
                        <div class="services__item__icon">
                            <img src="{{ template_frontpage('img/icons/si-4.png') }}" alt="">
                        </div>
                        <h4>Video hosting</h4>
                        <p>Whether you’re halfway through the editing process, or you haven’t even started, our post
                            production services can put the finishing touches.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Call To Action Section Begin -->
    <section class="callto sp__callto">
        <div class="container" id="sectionOther">
            <div class="callto__services spad set-bg-color" data-setbgcolor="{{ $settings['general_breadcrumb_color'] ?? '#1e2a45' }}">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-10 text-center">
                        <div class="callto__text">
                            <h2>{{ $service['title_section_other'] ?? '' }}</h2>
                            <p>{{ $service['body_section_other'] ?? '' }}
                            </p>
                            <a href="{{ $service['url_button_section_other'] ?? '' }}">{{ $service['text_button_section_other'] ?? '' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Call To Action Section End -->

    <!-- Logo Begin -->
    <div class="logo spad">
        <div class="container">
            <div class="logo__carousel owl-carousel" id="clientSection">
                <a href="#" class="logo__item"><img src="{{ template_frontpage('img/logo/logo-1.png') }}"
                        alt=""></a>
                <a href="#" class="logo__item"><img src="{{ template_frontpage('img/logo/logo-2.png') }}"
                        alt=""></a>
                <a href="#" class="logo__item"><img src="{{ template_frontpage('img/logo/logo-3.png') }}"
                        alt=""></a>
                <a href="#" class="logo__item"><img src="{{ template_frontpage('img/logo/logo-4.png') }}"
                        alt=""></a>
                <a href="#" class="logo__item"><img src="{{ template_frontpage('img/logo/logo-5.png') }}"
                        alt=""></a>
                <a href="#" class="logo__item"><img src="{{ template_frontpage('img/logo/logo-6.png') }}"
                        alt=""></a>
            </div>
        </div>
    </div>
    <!-- Logo End -->
@endsection

@push('js')
    <script type="text/javascript">
        // Function to initialize Owl Carousel
        function initOwlCarousel() {
            $(".logo__carousel").owlCarousel({
                loop: true,
                margin: 100,
                items: 6,
                dots: false,
                smartSpeed: 1200,
                autoHeight: false,
                autoplay: true,
                responsive: {
                    992: {
                        items: 5
                    },
                    768: {
                        items: 4
                    },
                    480: {
                        items: 3
                    },
                    320: {
                        items: 2
                    }
                }
            });
        }

        // Service
        $.ajax({
            type: "GET",
            url: "{{ route('web.service.getService') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": "GET",
            },
            success: function(respon) {
                let serviceHtml = ''

                for (let i = 0; i < respon.data.length; i++) {
                    const data = respon.data[i];

                    if (data.name === ('service_' + i)) {
                        let serviceJsonDecode = JSON.parse(data.value);
                        serviceHtml += `<div class="col-lg-4 col-md-6 col-sm-6">` +
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
                }
                $('#serviceSection').html(
                    serviceHtml
                );
            }
        });

        // Client
        $.ajax({
            type: "GET",
            url: "{{ route('web.service.getClient') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": "GET",
            },
            success: function(respon) {
                let clientHtml = ''

                for (let i = 0; i < respon.data.length; i++) {
                    const data = respon.data[i];

                    clientHtml += `<a href="` + data.website_url +
                        `" target="_blank" class="logo__item"><img class="client-logo" src="{{ asset_administrator('assets/media/client') }}/` +
                        data.img_url + `" alt=""></a>`;
                }
                $('#clientSection').html(
                    clientHtml
                );

                // Destroy and reinitialize Owl Carousel after updating content
                $('.logo__carousel').owlCarousel('destroy');
                initOwlCarousel();
            }
        });

        // Initial Owl Carousel initialization
        initOwlCarousel();
    </script>
@endpush
