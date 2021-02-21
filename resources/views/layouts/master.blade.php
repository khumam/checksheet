<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Barra Dev</title>

    <link rel="shortcut icon" href="{{ url('assets/images/logo/favicon.png') }}">
    <link href="{{ url('assets/css/app.min.css') }}" rel="stylesheet">

    @stack('css')

</head>

<body>
    <div class="app">
        <div class="layout">
            @include('layouts.topbar')
            @include('layouts.sidebar')
            <div class="page-container">

                <div class="main-content">
                    @yield('content')
                </div>

                <footer class="footer">
                    <div class="footer-content">
                        <p class="m-b-0">Copyright © {{ date('y') }} Barra Dev. All rights reserved.</p>
                        <span>
                            <a href="" class="text-gray m-r-15">Term &amp; Conditions</a>
                            <a href="" class="text-gray">Privacy &amp; Policy</a>
                        </span>
                    </div>
                </footer>

            </div>

            <!-- <div class="modal modal-left fade search" id="search-drawer">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header justify-content-between align-items-center">
                            <h5 class="modal-title">Search</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="anticon anticon-close"></i>
                            </button>
                        </div>
                        <div class="modal-body scrollable">
                            <div class="input-affix">
                                <i class="prefix-icon anticon anticon-search"></i>
                                <input type="text" class="form-control" placeholder="Search">
                            </div>

                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Search End-->

            <!-- Quick View START -->
            <!-- <div class="modal modal-right fade quick-view" id="quick-view">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header justify-content-between align-items-center">
                            <h5 class="modal-title">Quick View</h5>
                        </div>
                        <div class="modal-body scrollable">

                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Quick View END -->
        </div>
    </div>


    <script src="{{ url('assets/js/vendors.min.js') }}"></script>
    <script src="{{ url('assets/js/app.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @stack('js')

</body>

</html>