<div class="btn-group">
    <button type="button" class="btn btn-primary">@lang('site.action')</button>
    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
        <span class="sr-only"></span>
    </button>
    <div class="dropdown-menu" role="menu">
        <a href="{{ route(env('DASH_URL').'.clients.show',$id) }}" class="dropdown-item"
           >@lang('site.profile')</a>

        @if (auth()->user()->hasPermission('clients-update'))
            <a onclick="return edit_row('{{ route(env('DASH_URL').'.clients.edit',$id) }}')" class="dropdown-item"
               href="#">@lang('site.edit')</a>
        @endif

        @if (auth()->user()->hasPermission('clients-delete'))
            <form onsubmit="return delete_process('{{ route(env('DASH_URL').'.clients.remove',$id) }}')" id="delete-{{ $id }}"
                  class="delete-form"
                  action="{{ route(env('DASH_URL').'.clients.remove',$id) }}"
                  method="post" style="display: inline-block">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <a class="dropdown-item" onclick="delete_row({{ $id }})" href="#">@lang('site.delete')</a>
            </form>
        @endif
    </div>
</div>
