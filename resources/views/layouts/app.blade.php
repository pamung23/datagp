<!DOCTYPE html>
<html lang="id,in">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title') - Data Gepang</title>
    <link rel="icon" type="image/x-icon" href="https://datagp.gedepangrango.org/logo.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @stack('styles')

</head>

<body>

    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        @include('layouts.inc.header')
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN NAVBAR  -->
    <div class="sub-header-container">
        @include('layouts.inc.header2')
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('layouts.inc.sidebar')
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->

        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">

                    @yield('content')
                    {{-- @if(Session::has('error'))
                    <div id="myToast"
                        class="toast align-items-center text-white bg-danger border-0 position-fixed top-0 end-0 m-4"
                        role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                @if(Session::has('error'))
                                {{ Session::get('error') }}
                                @endif
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    @endif --}}
                </div>

            </div>
            @include('layouts.inc.footer')
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js')}}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('assets/js/app.js')}}"></script>
    <script src="{{ asset('assets/js/custom.js')}}"></script>
    <script src="{{ asset('plugins/highlight/highlight.pack.js')}}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myToast = new bootstrap.Toast(document.getElementById('myToast'), {
                delay: 9000 // durasi delay dalam milidetik (9 detik)
            });
            myToast.show();
        });
    </script>

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @stack('scripts')
    <script>
        $(document).ready(function() {
        App.init();
    
        $('.dropdown-toggle').on('click', function() {
            var isActive = $(this).attr('data-active') === 'true';
    
            var submenuId = $(this).attr('href');
            var otherSubmenuId = null;
    
            $('.dropdown-toggle').each(function() {
                otherSubmenuId = $(this).attr('href');
                if (otherSubmenuId !== submenuId) {
                    $(this).attr('data-active', false);
                    $(this).attr('aria-expanded', false);
                    localStorage.setItem(otherSubmenuId, 'false'); // Tetapkan semua yang tidak aktif ke localStorage
                }
            });
    
            isActive = !isActive;
            $(this).attr('data-active', isActive);
            $(this).attr('aria-expanded', isActive);
            localStorage.setItem(submenuId, isActive.toString());
    
            // Atur kelas 'active' pada tag <li> berdasarkan klik submenu
            if (isActive) {
                $(this).closest('.menu').addClass('active');
            } else {
                $(this).closest('.menu').removeClass('active');
            }
        });
    
        $('.dropdown-toggle').each(function() {
            var elementId = $(this).attr('href');
            var isActive = localStorage.getItem(elementId);
    
            if (isActive === 'true') {
                $(this).attr('data-active', true);
                $(this).attr('aria-expanded', true);
                $(this).closest('.menu').addClass('active'); // Tambahkan kelas 'active' pada tag <li> yang sesuai
            } else {
                $(this).attr('data-active', false);
                $(this).attr('aria-expanded', false);
                $(this).closest('.menu').removeClass('active'); // Hapus kelas 'active' pada tag <li> yang tidak aktif
                localStorage.setItem(elementId, 'false');
            }
        });
    
        // Atur kelas 'active' pada tag <li> berdasarkan URL yang aktif
        $('.menu a').filter(function() {
            return this.href === location.href;
        }).closest('.menu').addClass('active');
        // Ambil semua elemen anchor di dalam <li>
        var links = document.querySelectorAll('.menu a');

        // Loop melalui setiap elemen anchor
        links.forEach(function(link) {
            // Jika URL anchor cocok dengan URL saat ini
            if (link.href === window.location.href) {
                // Tambahkan kelas 'active' pada elemen <li> yang berisi anchor ini
                link.parentNode.classList.add('active');
            }
        });
    });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('logout-link').addEventListener('click', function (event) {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            });
        });
    </script>

</body>

</html>