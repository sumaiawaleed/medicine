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
