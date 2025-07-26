<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; {{ array_key_exists('nama_app_admin', $settings) ? $settings['nama_app_admin'] : '' }}</title>

    <link rel="shortcut icon"
        href="{{ array_key_exists('favicon', $settings) ? img_src($settings['favicon'], 'settings') : '' }}"
        type="image/png">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ template_stisla('modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ template_stisla('modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ template_stisla('modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/src/parsley.min.css">
    <link rel="stylesheet" href="{{ template_stisla('modules/izitoast/css/iziToast.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ template_stisla('css/style.css') }}">
    <link rel="stylesheet" href="{{ template_stisla('css/components.css') }}">
    @stack('css')
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        @yield('content')
    </div>

    <!-- General JS Scripts -->
    <script src="{{ template_stisla('modules/jquery.min.js') }}"></script>
    <script src="{{ template_stisla('modules/popper.js') }}"></script>
    <script src="{{ template_stisla('modules/tooltip.js') }}"></script>
    <script src="{{ template_stisla('modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ template_stisla('modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ template_stisla('modules/moment.min.js') }}"></script>
    <script src="{{ template_stisla('js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <!-- JS Libraies -->
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>
    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ template_stisla('js/scripts.js') }}"></script>
    <script src="{{ template_stisla('js/custom.js') }}"></script>

    <script src="{{ template_stisla('modules/izitoast/js/iziToast.min.js') }}"></script>

    <script src="{{ template_stisla('js/page/modules-toastr.js') }}"></script>
    <script>
        var toastMessages = {
            errors: [],
            error: @json(session('error')),
            success: @json(session('success')),
            warning: @json(session('warning')),
            info: @json(session('info'))
        };
    </script>
    @stack('js')
</body>

</html>
