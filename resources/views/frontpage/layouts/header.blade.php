<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="{{ route('web.index') }}">
                        <h2>{{ $settings['general_nama_app'] ?? '' }}</h2>
                    </a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="header__nav__option">
                    <nav class="header__nav__menu mobile-menu">
                        <ul>
                            <li class="{{ Route::is('web.index*') ? 'active' : '' }}"><a
                                    href="{{ route('web.index') }}">Home</a></li>
                            <li class="{{ Route::is('web.about*') ? 'active' : '' }}"><a
                                    href="{{ route('web.about') }}">About</a></li>
                            <li class="{{ Route::is('web.project*') ? 'active' : '' }}"><a
                                    href="{{ route('web.project') }}">Portfolio</a></li>
                            <li class="{{ Route::is('web.service*') ? 'active' : '' }}"><a
                                    href="{{ route('web.service') }}">Services</a></li>
                            <li class="{{ Route::is('web.blog*') ? 'active' : '' }}"><a
                                    href="{{ route('web.blog') }}">Blog</a></li>
                            {{-- <li class="{{ Route::is('web.blog*') ? 'active' : '' }}"><a
                                    href="javascript:void(0)">Blog</a>
                                <ul class="dropdown">
                                    <li><a href="{{ route('web.blog') }}">Post</a></li>
                                    <li><a href="{{ route('web.blog') }}">Kategori</a></li>
                                </ul>
                            </li> --}}
                            <li class="{{ Route::is('web.contact*') ? 'active' : '' }}"><a
                                    href="{{ route('web.contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                    <div class="header__nav__social">
                        @php
                            $sosmed = array_key_exists('general_sosmed', $settings) ? json_decode($settings['general_sosmed']) : null;
                        @endphp

                        @if (!empty($sosmed))
                            @foreach ($sosmed as $key => $item)
                                @if (!empty($item))
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
        <div id="mobile-menu-wrap"></div>
    </div>
</header>
<!-- Header End -->
