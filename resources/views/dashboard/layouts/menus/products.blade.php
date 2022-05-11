<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cubes"></i>
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
