<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/css/app-rtl.min.css', 'resources/css/app.min.css', 'resources/css/bootstrap-rtl.min.css', 'resources/css/bootstrap.min.css', 'resources/css/icons-rtl.min.css', 'resources/css/icons.css', 'resources/css/icons.min.css'])
    <title>@yield('title')</title>
</head>

<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="display-1 fw-bold">@yield('code')</h1>
            <p class="fs-3"> <span class="text-danger">@yield('message-1')
                    <p class="lead">
                        @yield('message-2')
                    </p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Home</a>
        </div>
    </div>
</body>

</html>
