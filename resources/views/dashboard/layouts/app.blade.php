<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings->getTranslateTitle(app()->getLocale()) }}| {{ $data['title'] }}</title>
    <link rel="stylesheet" href="{{ asset("public/dashboard/plugins/fontawesome-free/css/all.min.css")}}">
    @stack('styles')
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset("public/dashboard/dist/css/ar_adminlte.css")}}?v=2">
    @else
        <link rel="stylesheet" href="{{ asset("public/dashboard/dist/css/adminlte.min.css")}}">
    @endif
    <style>
        table{
            max-width: 100% !important;
        }
        #table_filter{
            display:none;
        }
        .help-block{
            color:red;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <img src="{{ auth()->user()->image_path  }}" style="height: 30px;" class="img-circle elevation-2"
                         alt="{{ auth()->user()->name }}">
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="{{ route(env('DASH_URL').'.profile') }}" class="dropdown-item">
                        @lang('site.profile')
                    </a>
                    <div class="dropdown-divider"></div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"
                       class="dropdown-item">
                        @lang('site.logout')
                    </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-globe"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" class="dropdown-item">
                        EN
                    </a>

                    <div class="dropdown-divider"></div>
                    <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" class="dropdown-item">
                        العربية
                    </a>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    @include('dashboard.layouts.menu')

    @yield('content')

    <footer class="main-footer d-print-none">
        @lang('site.copy') {{ $settings->getTranslateTitle(app()->getLocale()) }}
    </footer>

</div>

<script src="{{ asset("public/dashboard/plugins/jquery/jquery.min.js")}}"></script>
<script src="{{ asset("public/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{ asset("public/dashboard/dist/js/adminlte.min.js")}}"></script>
<script src="{{ asset("public/dashboard/dist/js/sweetalert.min.js")}}"></script>
@stack('scripts')
</body>
</html>
