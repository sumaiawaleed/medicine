<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route(env('DASH_URL').'.index') }}" class="brand-link">
        <img src="{{ asset('public/w-logo.svg') }}" width="33" height="33"
             alt="{{ $settings->getTranslateTitle(app()->getLocale()) }}" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ $settings->getTranslateTitle(app()->getLocale()) }}</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('dashboard.layouts.menus.main')
                @include('dashboard.layouts.menus.people')
                @include('dashboard.layouts.menus.products')

                @if (auth()->user()->hasPermission('settings-read'))
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route(env('DASH_URL').'.settings') }}" class="nav-link">--}}
{{--                            <i class="nav-icon fas @lang('icons.settings')"></i>--}}
{{--                            <p>--}}
{{--                                @lang('site.settings')--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                @endif
            </ul>
        </nav>

    </div>
</aside>
