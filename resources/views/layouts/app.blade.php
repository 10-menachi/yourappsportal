<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://kit.fontawesome.com/e53bf7a0b8.js" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Additional Stylesheets -->
    @vite(['resources/css/app.css', 'resources/css/app-rtl.min.css', 'resources/css/app.min.css', 'resources/css/bootstrap-rtl.min.css', 'resources/css/bootstrap.min.css', 'resources/css/icons-rtl.min.css', 'resources/css/icons.css', 'resources/css/icons.min.css'])

    <!-- Inline Styles -->
    <style>
        #layout-wrapper.sidebar-open .sidebar {
            transform: translateX(0);
        }

        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
    </style>

    <title>{{ config('app.name', 'Your Apps Portal') }}</title>
</head>

<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="#" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('images/logo-sm.png') }}" alt="" height="50">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/logo-dark.png') }}" alt="" height="50">
                            </span>
                        </a>
                        <a href="{{ route('dashboard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('images/logo-sm.png') }}" alt="" height="50">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/logo-light.png') }}" alt="" height="50">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <!-- Notifications -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa-solid fa-bell"></i>
                            <span class="badge bg-danger rounded-pill">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-16"> Notifications (258) </h5>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <!-- Notifications Items -->
                                @foreach (['order-placed', 'new-message', 'item-shipped'] as $notification)
                                    <a href="#" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-xs">
                                                    <span
                                                        class="avatar-title bg-{{ $notification }} rounded-circle font-size-16">
                                                        <i class="fa-solid fa-{{ $notification }}"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your {{ $notification }}</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">Notification message here.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="p-2 border-top">
                                <div class="d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center" href="#">View all</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('images/users/user-4.jpg') }}" alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#"><i
                                    class="fa-solid fa-user font-size-17 align-middle me-1"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit"><i
                                        class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i>
                                    Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </header>

    @include('components.sidebar')

    <div class="main-content" style="margin-right: 0 !important;">
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
                        {{ date('Y') }}
                        <span class="d-none d-sm-inline-block"> YourAppsLtd
                            &trade;</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('vertical-menu-btn').addEventListener('click', function() {
                document.getElementById('layout-wrapper').classList.toggle('sidebar-open');
            });
        });
    </script>

    @yield('modal')
    @stack('modal')
    @yield('script')
    @stack('script')
</body>

</html>
