<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Panel Admin &mdash; {{ array_key_exists('nama_app_admin', $settings) ? $settings['nama_app_admin'] : '' }}
    </title>

    <link rel="shortcut icon"
        href="{{ array_key_exists('favicon', $settings) ? img_src($settings['favicon'], 'settings') : '' }}"
        type="image/png">

    <!-- General CSS Files -->
    {{-- <link rel="stylesheet" href="{{template_stisla('modules/bootstrap/css/bootstrap.min.css')}}"> --}}
    <link rel="stylesheet" href="{{ template_stisla('modules/fontawesome/css/all.min.css') }}">
    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="{{template_stisla('modules/jqvmap/dist/jqvmap.min.css')}}"> --}}
    <link rel="stylesheet" href="{{ template_stisla('modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ template_stisla('modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ template_stisla('modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/src/parsley.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ template_stisla('modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ template_stisla('modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ template_stisla('modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ template_stisla('modules/izitoast/css/iziToast.min.css') }}">
    @stack('css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ template_stisla('css/style.css') }}">
    <link rel="stylesheet" href="{{ template_stisla('css/components.css') }}">
    <link rel="stylesheet" href="{{ template_stisla('css/custom.css') }}">

    <style>
        :root {
            --main-background-color: {{ $settings['admin_main_background_color'] ?? '#63ed7a' }};
        }
    </style>

    {{-- <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA --> --}}
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('administrator.layouts.nav')

            @include('administrator.layouts.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        @stack('section_header')
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">@stack('section_title')</h2>
                        @yield('content')
                    </div>
                </section>
            </div>
            @include('administrator.layouts.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('jquery/dist/jquery.js') }}"></script>
    <script src="{{ template_stisla('modules/popper.js') }}"></script>
    <script src="{{ template_stisla('modules/tooltip.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    {{-- <script src="{{template_stisla('modules/bootstrap/js/bootstrap.min.js')}}"></script> --}}
    <script src="{{ template_stisla('modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ template_stisla('modules/moment.min.js') }}"></script>
    <script src="{{ template_stisla('js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ template_stisla('modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
    {{-- <script src="{{template_stisla('modules/chart.min.js')}}"></script> --}}
    {{-- <script src="{{template_stisla('modules/jqvmap/dist/jquery.vmap.min.js')}}"></script> --}}
    {{-- <script src="{{template_stisla('modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script> --}}
    <script src="{{ template_stisla('modules/summernote/summernote-bs4.js') }}"></script>

    {{-- <script src="{{template_stisla('modules/sweetalert/sweetalert.min.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.all.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>

    <script src="{{ template_stisla('modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ template_stisla('modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ template_stisla('modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ template_stisla('modules/jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset_administrator('assets/plugins/form-jasnyupload/fileinput.min.js') }}"></script>

    <script src="{{ template_stisla('js/page/modules-toastr.js') }}"></script>
    <script src="{{ template_stisla('modules/izitoast/js/iziToast.min.js') }}"></script>
    @stack('js')
    <!-- Template JS File -->
    {{-- <script src="{{ template_stisla('js/page/index-0.js') }}"></script> --}}
    <script src="{{ template_stisla('js/scripts.js') }}"></script>
    <script src="{{ template_stisla('js/custom.js') }}"></script>

    <script>
        var toastMessages = {
            errors: [],
            error: @json(session('error')),
            success: @json(session('success')),
            warning: @json(session('warning')),
            info: @json(session('info'))
        };
    </script>

</body>

</html>
