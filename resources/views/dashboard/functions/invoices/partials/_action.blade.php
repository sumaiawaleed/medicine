<div class="btn-group">
    <button type="button" class="btn btn-primary">@lang('site.action')</button>
    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
        <span class="sr-only"></span>
    </button>
    <div class="dropdown-menu" role="menu">
        @if (auth()->user()->hasPermission('return_invoices-read'))
            <a href="{{ route(env('DASH_URL').'.return_invoices.index',['invoice_id' => $id ]) }}"
               class="dropdown-item">@lang('site.return_invoices')</a>
        @endif

        @if (auth()->user()->hasPermission('receipts-read'))
            <a href="{{ route(env('DASH_URL').'.receipts.index',['invoice_id' => $id ]) }}"
               class="dropdown-item">@lang('site.receipts')</a>
        @endif

        @if (auth()->user()->hasPermission('invoices-update'))
            <a onclick="return edit_row('{{ route(env('DASH_URL').'.invoices.edit',$id) }}')" class="dropdown-item"
               href="#">@lang('site.edit')</a>
        @endif

        @if (auth()->user()->hasPermission('invoices-delete'))
            <form onsubmit="return delete_process('{{ route(env('DASH_URL').'.invoices.remove',$id) }}')"
                  id="delete-{{ $id }}"
                  class="delete-form"
                  action="{{ route(env('DASH_URL').'.invoices.remove',$id) }}"
                  method="post" style="display: inline-block">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <a class="dropdown-item" onclick="delete_row({{ $id }})" href="#">@lang('site.delete')</a>
            </form>
        @endif
    </div>
</div>
