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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @stack('styles')
</head>

<body>

    <!-- BEGIN NAVBAR -->
    <div class="header-container fixed-top">
        @include('layouts.inc.header')
    </div>
    <!-- END NAVBAR -->

    <!-- BEGIN NAVBAR -->
    <div class="sub-header-container">
        @include('layouts.inc.header2')
    </div>
    <!-- END NAVBAR -->

    <!-- BEGIN MAIN CONTAINER -->
    <div class="main-container" id="container">
        <!-- Pemberitahuan -->
        <!-- ... (Bagian HTML lainnya) ... -->

        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">Error</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="errorModalBody">
                        <!-- Konten error akan ditampilkan di sini -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ... (Bagian HTML lainnya) ... -->

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!-- BEGIN SIDEBAR -->
        @include('layouts.inc.sidebar')
        <!-- END SIDEBAR -->

        <!-- BEGIN CONTENT AREA -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">
                    @yield('content')
                </div>
            </div>
            @include('layouts.inc.footer')
        </div>
        <!-- END CONTENT AREA -->

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @stack('scripts')
    <!-- ... (HTML lainnya) ... -->
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
                    localStorage.setItem(otherSubmenuId, 'false');
                }
            });

            isActive = !isActive;
            $(this).attr('data-active', isActive);
            $(this).attr('aria-expanded', isActive);
            localStorage.setItem(submenuId, isActive.toString());

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
                $(this).closest('.menu').addClass('active');
            } else {
                $(this).attr('data-active', false);
                $(this).attr('aria-expanded', false);
                $(this).closest('.menu').removeClass('active');
                localStorage.setItem(elementId, 'false');
            }
        });

        $('.menu a').filter(function() {
            return this.href === location.href;
        }).closest('.menu').addClass('active');

        var links = document.querySelectorAll('.menu a');

        links.forEach(function(link) {
            if (link.href === window.location.href) {
                link.parentNode.classList.add('active');
            }
        });

        // Ambil pesan error dari sesi Laravel dan tampilkan menggunakan SweetAlert2
        var errorMessage = '{{ Session::get('error') }}';
        if (errorMessage) {
            showNotification(errorMessage, 'error');
        }
    });

    function showNotification(message, type) {
        Swal.fire({
            icon: type === 'error' ? 'error' : 'success',
            title: type === 'error' ? 'Error' : 'Success',
            text: message,
        });
    }
    </script>
    <!-- ... (Script JavaScript lainnya) ... -->

</body>

</html>