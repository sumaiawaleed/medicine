<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            @lang('site.people')
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (auth()->user()->hasPermission('admins-read'))
            <li class="nav-item">
                <a href="{{ route(env('DASH_URL').'.admins.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>@lang('site.admins')</p>
                </a>
            </li>
        @endif

        @if (auth()->user()->hasPermission('employees-read'))
            <li class="nav-item">
                <a href="{{ route(env('DASH_URL').'.employees.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>@lang('site.employees')</p>
                </a>
            </li>
        @endif

        @if (auth()->user()->hasPermission('clients-read'))
            <li class="nav-item">
                <a href="{{ route(env('DASH_URL').'.clients.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>@lang('site.clients')</p>
                </a>
            </li>
        @endif

        @if (auth()->user()->hasPermission('roles-read'))
            <li class="nav-item">
                <a href="{{ route(env('DASH_URL').'.roles.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>@lang('site.roles')</p>
                </a>
            </li>
        @endif
    </ul>
</li>
