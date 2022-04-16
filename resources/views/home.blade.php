<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>{{ $settings->getTranslateTitle(app()->getLocale()) }}</title>
    <link rel="icon" href="{{ asset('public/assets/images/favicon.ico')}}" type="image/x-icon">

    <!-- Stylesheets -->
    <link href="{{ asset('public/assets/css/font-awesome-all.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/owl.css')}}" rel="stylesheet">
    @if(app()->getLocale() == 'ar')
        <link href="{{ asset('public/assets/css/rtl.css')}}?v=2" rel="stylesheet">
        <link href="{{ asset('public/assets/css/ar_responsive.css')}}?v=4" rel="stylesheet">
    @else
        <link href="{{ asset('public/assets/css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/css/jquery.fancybox.min.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/css/animate.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/css/style.css')}}?v=2" rel="stylesheet">
        <link href="{{ asset('public/assets/css/responsive.css')}}?v=2" rel="stylesheet">
    @endif

    <style>
        @font-face {
            font-family: 'IBMPlexSansArabic';
            src: url({{ asset('public/assets/font/IBMPlexSansArabic-Regular.ttf') }});
        }

        body, h1, h2, h3, h4, h5, h6, p, a {
            font-family: 'IBMPlexSansArabic', sans-serif !important;
        }

    </style>

</head>
<body dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<div class="boxed_wrapper">
    <header class="main-header style-four style-five">
        <div class="header-lower">
            <div class="outer-box">
                <div class="logo-box">
                    <figure class="logo"><a href="/"><img src="{{ asset('public/assets/images/logo-2.png')}}"
                                                          style="width:75px" alt=""></a></figure>
                </div>
                <div class="menu-area clearfix">
                    <div class="mobile-nav-toggler">
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                    </div>
                    <nav class="main-menu navbar-expand-md navbar-light">
                        <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                            <ul class="navigation scroll-nav clearfix">

                                <li class="current "><a href="#home">@lang('site.home')</a>

                                </li>
                                <li><a href="#about">@lang('site.about')</a></li>
                                <li><a href="#statistics">@lang('site.statistics')</a></li>
                                <li><a href="#projects">@lang('site.projects')</a></li>
                                <li><a href="#why_us">@lang('site.why_us')</a></li>
                                <li><a href="#partners">@lang('site.partners')</a></li>
                                <li class="lang_item">
                                    @if(app()->getLocale() == 'ar')
                                        <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"
                                        >En</a>
                                    @else
                                        <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"
                                        >العربية</a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <ul class="menu-right-content clearfix">
                    @if(app()->getLocale() == 'ar')
                        <li class="btn-box">
                            <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"
                               class="btn btn-outline-light">En</a>
                        </li>
                    @else
                        <li class="btn-box">
                            <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"
                               class="btn btn-outline-light">العربية</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!--sticky Header-->
        <div class="sticky-header">
            <div class="auto-container">
                <div class="outer-box clearfix">

                    <div class="menu-area pull-left">

                        <nav class="main-menu clearfix">

                            <!--Keep This Empty / Menu will come through Javascript-->
                        </nav>
                    </div>
                    <ul class="menu-right-content pull-right clearfix">

                        @if(app()->getLocale() == 'ar')
                            <li class="btn-box">
                                <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"
                                   class="btn btn-outline-primary mt-2">En</a>
                            </li>
                        @else
                            <li class="btn-box">
                                <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"
                                   class="btn btn-outline-primary mt-2">العربية</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu  -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <div class="close-btn"><i class="fas fa-times"></i></div>

        <nav class="menu-box">
            <div class="nav-logo"><a href="index.html"><img src="{{ asset('public/assets/images/logo-2.png')}}"
                                                            style="width:75px" alt="" title=""></a></div>
            <div class="menu-outer">
                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>

        </nav>
    </div>

@include('pages.home')
@include('pages.about')
@include('pages.statistics')
@include('pages.projects')
@include('pages.services')
@include('pages.partners')


<!-- main-footer -->
    <footer class="main-footer mt-5 bg-color-4">

        <div class="footer-bottom ">
            <div class="auto-container">
                <div class="row">
                    <div class="col-md-4">
                        <figure class="logo"><a href="/"><img src="{{ asset('public/assets/images/logo-2.png')}}"
                                                              style="width:75px" alt=""></a></figure>

                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="copyright">
                            <p>@lang('site.copy')
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <div class="social-buttons">
                            <a href="{{ $settings->facebook }}"
                               class="social-buttons__button social-button social-button--facebook"
                               aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="{{ $settings->twitter }}"
                               class="social-buttons__button social-button social-button--linkedin"
                               aria-label="LinkedIn">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="{{ $settings->linkedin }}"
                               class="social-buttons__button social-button social-button--snapchat"
                               aria-label="SnapChat">
                                <i class="fab fa-snapchat-ghost"></i>
                            </a>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </footer>
    <!-- main-footer end -->


    <!--Scroll to top-->
    <button class="scroll-top scroll-to-target" data-target="html">
        <span class="fal fa-angle-up"></span>
    </button>
</div>


<script src="{{ asset('public/assets/js/jquery.js')}}"></script>
<script src="{{ asset('public/assets/js/popper.min.js')}}"></script>
<script src="{{ asset('public/assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('public/assets/js/owl.js')}}"></script>
<script src="{{ asset('public/assets/js/wow.js')}}"></script>
<script src="{{ asset('public/assets/js/jquery.fancybox.js')}}"></script>
<script src="{{ asset('public/assets/js/appear.js')}}"></script>
<script src="{{ asset('public/assets/js/isotope.js')}}"></script>
<script src="{{ asset('public/assets/js/jquery.nice-select.min.js')}}"></script>
<script src="{{ asset('public/assets/js/nav-tool.js')}}"></script>
<script src="{{ asset('public/assets/js/jquery.paroller.min.js')}}"></script>
<script src="{{ asset('public/assets/js/pagenav.js')}}"></script>
@if(app()->getLocale() == 'ar')
    <script src="{{ asset('public/assets/js/ar_script.js')}}?v=2"></script>
@else
    <script src="{{ asset('public/assets/js/script.js')}}"></script>
@endif
</body><!-- End of .page_wrapper -->
</html>
