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

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            @lang('site.places')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (auth()->user()->hasPermission('cities-read'))
                            <li class="nav-item">
                                <a href="{{ route(env('DASH_URL').'.cities.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('site.cities')</p>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->hasPermission('areas-read'))
                            <li class="nav-item">
                                <a href="{{ route(env('DASH_URL').'.areas.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('site.areas')</p>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->hasPermission('locations-read'))
                            <li class="nav-item">
                                <a href="{{ route(env('DASH_URL').'.locations.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('site.locations')</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            @lang('site.products')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (auth()->user()->hasPermission('categories-read'))
                            <li class="nav-item">
                                <a href="{{ route(env('DASH_URL').'.categories.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('site.categories')</p>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->hasPermission('products-read'))
                            <li class="nav-item">
                                <a href="{{ route(env('DASH_URL').'.products.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('site.products')</p>
                                </a>
                            </li>
                        @endif


                    </ul>
                </li>


                @if (auth()->user()->hasPermission('users-read'))
                    <li class="nav-item">
                        <a href="{{ route(env('DASH_URL').'.users.index') }}" class="nav-link">
                            <i class="nav-icon fas @lang('icons.users')"></i>
                            <p>
                                @lang('site.users')
                            </p>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasPermission('settings-read'))
                    <li class="nav-item">
                        <a href="{{ route(env('DASH_URL').'.settings') }}" class="nav-link">
                            <i class="nav-icon fas @lang('icons.settings')"></i>
                            <p>
                                @lang('site.settings')
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

    </div>
</aside>
