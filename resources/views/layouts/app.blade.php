<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Dashboard | Veltrix - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="" name="author">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link href="{{ asset('libs/chartist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    @vite(['resources/css/app-rtl.min.css', 'resources/css/app.css', 'resources/css/bootstrap-rtl.min.css', 'resources/css/bootstrap.css', 'resources/css/icons-rtl.min.css', 'resources/css/icons.css'])

    @stack('style')

    <style>
        .btn-primary {
            -webkit-box-shadow: 0 2px 6px 0 rgba(81, 86, 190, .5);
            box-shadow: 0 2px 6px 0 rgba(81, 86, 190, .5);
        }

        .btn-secondary {
            -webkit-box-shadow: 0 2px 6px 0 rgba(116, 120, 141, .5);
            box-shadow: 0 2px 6px 0 rgba(116, 120, 141, .5);
        }

        .btn-success {
            -webkit-box-shadow: 0 2px 6px 0 rgba(42, 181, 125, .5);
            box-shadow: 0 2px 6px 0 rgba(42, 181, 125, .5);
        }

        .btn-info {
            -webkit-box-shadow: 0 2px 6px 0 rgba(75, 166, 239, .5);
            box-shadow: 0 2px 6px 0 rgba(75, 166, 239, .5);
        }

        .btn-warning {
            -webkit-box-shadow: 0 2px 6px 0 rgba(255, 191, 83, .5);
            box-shadow: 0 2px 6px 0 rgba(255, 191, 83, .5);
        }

        .btn-danger {
            -webkit-box-shadow: 0 2px 6px 0 rgba(253, 98, 94, .5);
            box-shadow: 0 2px 6px 0 rgba(253, 98, 94, .5);
        }

        .btn-dark {
            -webkit-box-shadow: 0 2px 6px 0 rgba(44, 48, 46, .5);
            box-shadow: 0 2px 6px 0 rgba(44, 48, 46, .5);
        }

        .btn-light {
            -webkit-box-shadow: 0 2px 6px 0 rgba(233, 233, 239, .5);
            box-shadow: 0 2px 6px 0 rgba(233, 233, 239, .5);
        }
    </style>
</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">

        @include('components.header')

        @include('components.sidebar')

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Veltrix<span class="d-none d-sm-inline-block"> - Crafted with <i
                                    class="mdi mdi-heart text-danger"></i> by Themesbrand.</span>
                        </div>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    @yield('modal')
    @stack('modal')

    <!-- JAVASCRIPT -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>

    @stack('script')

</body>

</html>
