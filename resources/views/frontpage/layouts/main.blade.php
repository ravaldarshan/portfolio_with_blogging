<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Videograph Template">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ array_key_exists('general_nama_app', $settings) ? $settings['general_nama_app'] : '' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ array_key_exists('general_frontpage_favicon', $settings) ? img_src($settings['general_frontpage_favicon'], 'settings') : '' }}">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{template_frontpage('css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{template_frontpage('css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{template_frontpage('css/elegant-icons.css')}}" type="text/css">
    <!-- Add Owl Carousel CSS and JS CDN links if not already added -->
    <link rel="stylesheet" href="{{template_frontpage('css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{template_frontpage('css/magnific-popup.css')}}" type="text/css">
    <link rel="stylesheet" href="{{template_frontpage('css/slicknav.min.css')}}" type="text/css">
    <style>
        :root {
            --main-text-color: {{ $settings['general_main_text_color'] ?? '#ffffff' }};
            --primary-color: {{ $settings['general_primary_color'] ?? '#cbd2ea' }};
            --background-color: {{ $settings['general_background_color'] ?? '#516192' }};
            --counter-color: {{ $settings['general_counter_color'] ?? '#060607' }};
            --footer-color: {{ $settings['general_footer_color'] ?? '#060607' }};
            --service-item-icon: {{ $settings['general_service_item_icon_color'] ?? '#cbd2ea' }};
        }
    </style>
    <link rel="stylesheet" href="{{template_frontpage('css/style.css')}}" type="text/css">
    
    @stack('css')
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    {{-- <div id="app"> --}}
        @include('frontpage.layouts.header')
    
        @yield('content')
    
        @include('frontpage.layouts.footer')
    {{-- </div> --}}

    <!-- Js Plugins -->
    <script src="{{ asset('jquery/dist/jquery.js') }}"></script>
    <script src="{{template_frontpage('js/bootstrap.min.js')}}"></script>
    <script src="{{template_frontpage('js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{template_frontpage('js/mixitup.min.js')}}"></script>
    <script src="{{template_frontpage('js/masonry.pkgd.min.js')}}"></script>
    <script src="{{template_frontpage('js/jquery.slicknav.js')}}"></script>
    <script src="{{template_frontpage('js/owl.carousel.min.js')}}"></script>
    <script src="{{template_frontpage('js/main.js')}}"></script>
    @stack('js')

</body>

</html>