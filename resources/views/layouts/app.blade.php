<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Barra Dev</title>

    <link rel="shortcut icon" href="{{ url('assets/images/logo/favicon.png') }}">
    <link href="{{ url('assets/css/app.min.css') }}" rel="stylesheet">

    @stack('css')
    @livewireStyles

</head>

<body>
    <div class="app">
        <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('assets/images/others/login-3.png')">
            <div class="d-flex flex-column justify-content-between w-100">
                <div class="container d-flex h-100">
                    @yield('content')
                </div>
                <div class="d-none d-md-flex p-h-40 justify-content-between">
                    <span class="">Copyright © {{ date('y') }} Barra Dev</span>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a class="text-dark text-link" href="">Legal</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-dark text-link" href="">Privacy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ url('assets/js/vendors.min.js') }}"></script>
    <script src="{{ url('assets/js/app.min.js') }}"></script>

    @stack('js')
    @livewireScripts

</body>

</html>