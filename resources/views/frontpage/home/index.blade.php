@extends('frontpage.layouts.main')

@section('content')
    <section class="hero">
        <div class="hero__slider owl-carousel" id="bannerSection">
            <div class="hero__item set-bg" data-setbg="https://i.giphy.com/XfDiixCqdH7OrEBg5z.webp">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <div class="hero__text">
                                <span>Website and video editing services</span>
                                <h2>Portfolio</h2>
                                <a href="#" class="primary-btn">See more about us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__item set-bg" data-setbg="https://i.giphy.com/XfDiixCqdH7OrEBg5z.webp">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <div class="hero__text">
                                <span>Website and video editing services</span>
                                <h2>Portfolio</h2>
                                <a href="#" class="primary-btn">See more about us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__item set-bg" data-setbg="https://i.giphy.com/XfDiixCqdH7OrEBg5z.webp">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <div class="hero__text">
                                <span>Website and video editing services</span>
                                <h2>Portfolio</h2>
                                <a href="#" class="primary-btn">See more about us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Services Section Begin -->
    <section class="services spad">
        <div class="container">
            <div class="row" id="sectionService">
                <div class="col-lg-4">
                    <div class="services__title">
                        <div class="section-title">
                            <span>Our services</span>
                            <h2>What We do?</h2>
                        </div>
                        <p>{{ $settings['body_service_frontpage_homepage'] ?? '' }}</p>
                        <a href="{{ route('web.service') }}" class="primary-btn">View all services</a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row" id="serviceSection">
                        {{-- fetch data service --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Work Section Begin -->
    <section class="team spad set-bg-color" data-setbgcolor="{{ $settings['general_breadcrumb_color'] ?? '#1e2a45' }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title team__title">
                        <span>Our Work</span>
                        <h2>Live projects</h2>
                    </div>
                </div>
            </div>
            <div id="projectSection" class="row latest__slider owl-carousel">
            </div>
        </div>
    </section>
    <!-- Counter Section Begin -->
    <section class="counter">
        <div class="container">
            <div class="counter__content">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item">
                            <div class="counter__item__text">
                                <img src="{{ template_frontpage('img/icons/ci-1.png') }}" alt="">
                                <h2 class="counter_num" id="countProject">99</h2>
                                <p>Compled Projects</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item second__item">
                            <div class="counter__item__text">
                                <img src="{{ template_frontpage('img/icons/ci-2.png') }}" alt="">
                                <h2 class="counter_num" id="countClient">245</h2>
                                <p>Happy clients</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item third__item">
                            <div class="counter__item__text">
                                <img src="{{ template_frontpage('img/icons/ci-3.png') }}" alt="">
                                <h2 class="counter_num" id="countService">145</h2>
                                <p>Service</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item four__item">
                            <div class="counter__item__text">
                                <img src="{{ template_frontpage('img/icons/ci-4.png') }}" alt="">
                                <h2 class="counter_num" id="countBlog">453</h2>
                                <p>Blog</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Section End -->


    <!-- Team Section Begin -->
    <section class="team spad set-bg-color" data-setbgcolor="{{ $settings['general_breadcrumb_color'] ?? '#1e2a45' }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title team__title">
                        <span>Nice to meet</span>
                        <h2>OUR Team</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-around" id="teamsSection">
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Latest Blog Section Begin -->
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Our Blog</span>
                        <h2>Blog Update</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="latest__slider owl-carousel" id="blogSection">
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->

    <!-- Call To Action Section Begin -->
    <section class="callto spad set-bg-color" id="sectionPromotion"
        data-setbgcolor="{{ $settings['general_breadcrumb_color'] ?? '#1e2a45' }}"
        style="background-image: url({{ template_frontpage('img/callto-bg.png') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="callto__text">
                        <h2>{{ $settings['title_promosi_frontpage_homepage'] ?? '' }}</h2>
                        <p>{{ $settings['body_promosi_frontpage_homepage'] ?? '' }}</p>
                        <a class="primary-btn" style="background-color: unset;"
                            href="{{ $settings['url_button_promosi_frontpage_homepage'] ?? '' }}">{{ $settings['text_button_promosi_frontpage_homepage'] ?? '' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Call To Action Section End -->
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            function formatDate(inputDate) {
                const months = [
                    "Jan", "Feb", "Mar", "Apr",
                    "May", "Jun", "Jul", "Aug",
                    "Sep", "Oct", "Nov", "Dec"
                ];

                const parts = inputDate.split("-");
                const year = parts[0];
                const month = months[parseInt(parts[1]) - 1];
                const day = parts[2];

                return `${month} ${day}, ${year}`;
            }

            function initOwlCarousel() {
                $(".logo__carousel").owlCarousel({
                    // loop: true,
                    margin: 0,
                    items: 3,
                    dots: true,
                    dotsEach: 2,
                    smartSpeed: 1200,
                    autoHeight: false,
                    autoplay: true,
                    responsive: {
                        992: {
                            items: 3
                        },
                        768: {
                            items: 2
                        },
                        320: {
                            items: 1
                        }
                    }
                });
            }


            //Service
            $.ajax({
                type: "GET",
                url: "{{ route('web.getService') }}",
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

            //Project
            $.ajax({
                type: "GET",
                url: "{{ route('web.getProject') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "GET",
                },
                success: function(respon) {
                    let projectHtml = ''

                    for (let i = 0; i < respon.data.length; i++) {
                        const data = respon.data[i];
                        let imgJsonDecode = JSON.parse(data.img_url);
                        let postUrl = data.url || '#';
                        let title = data.title || data.nama || 'Untitled';
                        let imageUrl = imgJsonDecode[0] ?
                            "{{ asset('administrator/assets/media/project') }}/" + imgJsonDecode[0] :
                            'https://via.placeholder.com/382x271';
                        let date = data.date || data.created_at || '';
                        let alt = title;

                        projectHtml += `
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                            <a href="${postUrl}" class="text-decoration-none text-dark" title="${data.nama}">
                                <div class="blog__item position-relative" style="aspect-ratio: 382 / 271; overflow: hidden;">
                                    <img loading="lazy" src="${imageUrl}"
                                        alt="${alt}"
                                        class="w-100 h-100 object-fit-cover" style="border-radius: 5px;" />
                                </div>
                                <div class="mt-2">
                                    <h4 class="fw-bold mb-1 text-white">${data.nama}</h4>
                                    <h6 class="text-muted mb-1">${data.category_project.nama}</h6>
                                </div>
                            </a>
                        </div>`;
                    }
                    $('#projectSection').html(
                        projectHtml
                    )
                    $('.set-bg').each(function() {
                        var bg = $(this).data('setbg');
                        $(this).css('background-image', 'url(' + bg + ')');
                    });
                }
            });

            // Blog
            $.ajax({
                type: "GET",
                url: "{{ route('web.getBlog') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "GET",
                },
                success: function(respon) {
                    let blogHtml = '';

                    for (let i = 0; i < respon.data.length; i++) {
                        const data = respon.data[i];
                        let imgJsonDecode = JSON.parse(data.img_url);

                        // Assuming data.contents contains the text with HTML tags
                        let contentWithHTML = data.contents;

                        // Remove HTML tags
                        let contentWithoutHTML = contentWithHTML.replace(/<\/?[^>]+(>|$)/g, '');

                        // Limit the content to 200 characters
                        const maxLength = 200;
                        let truncatedContent = contentWithoutHTML.length > maxLength ?
                            contentWithoutHTML.substring(0, maxLength) + '...' :
                            contentWithoutHTML;

                        blogHtml += `
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                <a href="/blog/${data.slug}"
                                    class="text-decoration-none text-dark"
                                    title="${data.title}">
                                    <div class="blog__item position-relative"
                                        style="aspect-ratio: 382 / 271; overflow: hidden;">
                                        <img loading="lazy"
                                            src="{{ asset('administrator/assets/media/blog') }}/${imgJsonDecode[0]}"
                                            alt="${data.title}"
                                            class="w-100 h-100 object-fit-cover"
                                            style="border-radius: 5px;" />
                                    </div>
                                    <div class="mt-2">
                                        <h4 class="fw-bold mb-1 text-white">${data.title}</h4>
                                        <h6 class="text-muted mb-1"></h6>
                                        <small class="text-secondary">${formatDate(data.posting_date)}</small>
                                    </div>
                                </a>
                            </div>
                        `;
                    }
                    // Move this line inside the success callback
                    $('#blogSection').html(blogHtml);

                    $('.set-bg-blog').each(
                        function() {
                            var bg = $(this).data('setbg');
                            $(this).css('background-image', 'url(' + bg + ')');
                        }
                    );
                    initOwlCarousel();
                }
            });

            function initcarousel() {
                $('#bannerSection').owlCarousel({
                    loop: true,
                    dots: true,
                    mouseDrag: false,
                    animateOut: 'fadeOut',
                    animateIn: 'fadeIn',
                    items: 1,
                    margin: 0,
                    smartSpeed: 1200,
                    autoHeight: false,
                    autoplay: true,
                });

                var dot = $('#bannerSection .owl-dot');
                dot.each(function() {
                    var index = $(this).index() + 1;
                    if (index < 10) {
                        $(this).html('0').append(index);
                    } else {
                        $(this).html(index);
                    }
                });
            }

            //Service
            $.ajax({
                type: "GET",
                url: "{{ route('web.getBanner') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "GET",
                },
                success: function(respon) {
                    let bannerHtml = ''

                    if (respon.data.length !== 0) {
                        for (let i = 0; i < respon.data.length; i++) {
                            const data = respon.data[i];

                            let bannerJsonDecode = JSON.parse(data.value);
                            bannerHtml +=
                                `<div class="hero__item set-bg-banner" data-setbg="{{ asset('administrator/assets/media/banner') }}/` +
                                bannerJsonDecode.img_url + `">` +
                                `<div class="container">` +
                                `<div class="row text-center">` +
                                `<div class="col-lg-12">` +
                                `<div class="hero__text">` +
                                `<span>` + bannerJsonDecode.title + `</span>` +
                                `<h2>` + bannerJsonDecode.body + `</h2>` +
                                `<a href="javascript:void(0)" class="primary-btn">See more about us</a>` +
                                `</div>` +
                                `</div>` +
                                `</div>` +
                                `</div>` +
                                `</div>`;
                        }
                        $('#bannerSection').html(
                            bannerHtml
                        )

                        $('.set-bg-banner').each(function() {
                            var bg = $(this).data('setbg');
                            $(this).css('background-image', 'url(' + bg + ')');
                        });

                        $('#bannerSection').owlCarousel('destroy');
                        initcarousel();
                    }
                }
            });
            initcarousel();

            $.ajax({
                type: "GET",
                url: "{{ route('web.getTeams') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "GET",
                },
                success: function(respon) {
                    let clientHtml = ''
                    for (let i = 0; i < respon.data.length; i++) {
                        const data = respon.data[i];
                        let social_media = JSON.parse(data.social_media);
                        clientHtml += `
                            <div class="col-lg-3 col-md-6 col-sm-6 p-0">
                                <div class="team__item set-bg" data-setbg="{{ asset('administrator/assets/media/profile') }}/${data.photo}" style="background-image: url('{{ asset('administrator/assets/media/profile') }}/${data.photo}');">
                                    <div class="team__item__text">
                                        <div class="team-owner-name">${data.full_name}</div>
                                        <p>${data.designation ?? '-'}</p>
                                        <div class="team__item__social">
                                            ${social_media.linkedin != '' ? `<a target="_blank" aria-label="Visit LinkedIn Profile" href="${social_media.linkedin}"><i class="fa-brands fa-linkedin"></i></a>` : ''}
                                            ${social_media.twitter != '' ? `<a target="_blank" aria-label="Visit Twitter Profile" href="${social_media.twitter}"><i class="fa-brands fa-twitter"></i></a>` : ''}
                                            ${social_media.facebook != '' ? `<a target="_blank" aria-label="Visit Facebook Profile" href="${social_media.facebook}"><i class="fa-brands fa-facebook"></i></a>` : ''}
                                            ${social_media.instagram != '' ? `<a aria-label="Visit Instagram Profile" target="_blank" href="${social_media.instagram}"><i class="fa-brands fa-instagram"></i></a>` : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                    }
                    $('#teamsSection').html(
                        clientHtml
                    );

                    // Destroy and reinitialize Owl Carousel after updating content
                    $('.logo__carousel').owlCarousel('destroy');
                    initOwlCarousel();
                }
            });


            //Count
            $.ajax({
                type: "GET",
                url: "{{ route('web.count') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "GET",
                },
                success: function(respon) {
                    const data = respon.data;
                    $('#countProject').html(
                        data.countProject
                    )
                    $('#countBlog').html(
                        data.countBlog
                    )
                    $('#countService').html(
                        data.countService
                    )
                    $('#countClient').html(
                        data.countClient
                    )
                    $('.counter_num').each(function() {
                        $(this).prop('Counter', 0).animate({
                            Counter: $(this).text()
                        }, {
                            duration: 4000,
                            easing: 'swing',
                            step: function(now) {
                                $(this).text(Math.ceil(now));
                            }
                        });
                    });
                }
            });
        });
    </script>
@endpush
