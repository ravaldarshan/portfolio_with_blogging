<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="footer__top">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="footer__top__logo">
                        <a href="#">
                            <h2>{{ $settings['general_nama_app'] ?? '' }}</h2>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="footer__top__social">
                        @php
                            $sosmed = array_key_exists('general_sosmed', $settings) ? json_decode($settings['general_sosmed']) : null;
                        @endphp
                        @if (!empty($sosmed))
                            @foreach ($sosmed as $key => $item)
                                @if (!empty($item->icon_sosmed))
                                    <a href="{{ $item->nama_sosmed }}" target="_blank">
                                        <i class="{{ $item->icon_sosmed }}"></i>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__option">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer__option__item">
                        <h5>About us</h5>
                        <p>{{ array_key_exists('about_frontpage_footer', $settings) ? $settings['about_frontpage_footer'] : '' }}
                        </p>
                        <a href="{{ route('web.about') }}" class="read__more">See more about us 
                            <span class="arrow_right"></span></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="footer__option__item">
                        <h5>Who we are</h5>
                        <ul>
                            <li><a href="{{ route('web.project') }}">Project</a></li>
                            <li><a href="{{ route('web.service') }}">Service</a></li>
                            <li><a href="{{ route('web.blog') }}">Blog</a></li>
                            <li><a href="{{ route('web.contact') }}">Contact us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="footer__option__item">
                        <h5>Our link</h5>
                        <ul>
                            @php
                                $link = array_key_exists('link_frontpage_footer', $settings) ? json_decode($settings['link_frontpage_footer']) : null;
                            @endphp
                            @if (!empty($link))
                                @foreach ($link as $key => $item)
                                    @if (!empty($item->url_link))
                                        <a href="{{ $item->url_link }}" target="_blank">
                                            <i class="{{ $item->nama_link }}"></i>
                                        </a>
                                        <li><a href="{{ $item->url_link }}" target="_blank">{{ $item->nama_link }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__option__item">
                        <h5>Subscribe Now</h5>
                        <form action="{{ route('web.subscribe') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="email" placeholder="Enter your email address" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-sm btn-icon" type="submit" id="button-addon2">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__copyright">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="footer__copyright__text">
                        {!! array_key_exists('text_frontpage_footer', $settings) ? $settings['text_frontpage_footer'] : '' !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->
