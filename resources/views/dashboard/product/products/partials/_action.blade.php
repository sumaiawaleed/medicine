<div class="btn-group">
    <button type="button" class="btn btn-primary">@lang('site.action')</button>
    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
        <span class="sr-only"></span>
    </button>
    <div class="dropdown-menu" role="menu">
        @if (auth()->user()->hasPermission('product_units-read'))
            <a  class="dropdown-item"
               href="{{ route(env('DASH_URL').'.product_units.index',['id' => $id]) }}">@lang('site.product_units')</a>
        @endif

            @if (auth()->user()->hasPermission('products-update'))
            <a  class="dropdown-item"
               href="{{ route(env('DASH_URL').'.products.edit',$id) }}">@lang('site.edit')</a>
        @endif

        @if (auth()->user()->hasPermission('products-delete'))
            <form onsubmit="return delete_process('{{ route(env('DASH_URL').'.products.remove',$id) }}')" id="delete-{{ $id }}"
                  class="delete-form"
                  action="{{ route(env('DASH_URL').'.products.remove',$id) }}"
                  method="post" style="display: inline-block">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <a class="dropdown-item" onclick="delete_row({{ $id }})" href="#">@lang('site.delete')</a>
            </form>
        @endif
    </div>
</div>
