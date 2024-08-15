<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Portal YourApps</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app-rtl.min.css', 'resources/css/app.css', 'resources/css/bootstrap-rtl.min.css', 'resources/css/bootstrap.css', 'resources/css/icons-rtl.min.css', 'resources/css/icons.css'])
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <img src="{{ asset('logo.png') }}" alt="" class="img-fluid pt-2"
                                        style="height: 100px; margin: 0 auto;">
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="p-3 text-center">
                                        <h5>Welcome Back !</h5>
                                        <p>Sign in to YourApp</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="p-2">
                                <!-- Laravel Form Handling -->
                                <form method="POST" action="{{ route('login') }}" id="form-horizontal"
                                    class="needs-validation form-horizontal">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="username" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" name="email" id="username"
                                            placeholder="Enter E-mail" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Enter password" aria-label="Password" required>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>
                                </form>

                                <!-- Validation Errors -->
                                @if ($errors->any())
                                    <div class="mt-4">
                                        <ul class="list-unstyled">
                                            @foreach ($errors->all() as $error)
                                                <li class="text-danger">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-5 text-center">
                                <div class="text-dark">
                                    <p>©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> YourApp
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('vendor/parsley.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        let formHorizontal = $("#form-horizontal");
        formHorizontal.on('blur', 'input', function(e) {
            let placeholder = $(this).attr('data-placeholder');
            $(this).attr('placeholder', placeholder);
        });

        formHorizontal.on('focus', 'input', function(e) {
            $(this).attr('data-placeholder', $(this).attr('placeholder'));
            $(this).attr('placeholder', '');
        });

        formHorizontal.parsley({
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorsWrapper: '<ul class="parsley-errors-list list-unstyled mb-1"></ul>',
            errorTemplate: '<li class="parsley-error text-danger font-size-10"></li>'
        });
    </script>
</body>

</html>
