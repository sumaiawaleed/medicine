<div class="modal fade" id="create-model" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('site.create') @lang('site.one_client_fin_accounts')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="add_new_form" method="post" action="{{ route(env('DASH_URL').'.client_fin_accounts.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                    <div class="box-body">
                        <input type="hidden" name="client_id" value="{{ $data['client']->id }}">
                        @include('dashboard.functions.client_fin_accounts.partials._form')
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">@lang('site.add')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
