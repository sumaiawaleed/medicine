<div class="modal fade" id="add-sub-model" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('site.renew') @lang('site.one_subscribe')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" class="form" method="post" action="{{ route(env('DASH_URL').'.clients.subscribe.add') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="add_sub_id" id="add_sub_id">
                            <div class="col-md-6">
                                <div class="form-group" id="add_subscribe_id">
                                    <label for="add_subscribe_id_input">@lang('site.add_subscribe_id')</label>
                                    <select name="add_subscribe_id" id="add_subscribe_id_input" class="form-control">
                                        <option value="">@lang('site.select') @lang('site.add_subscribe_id')</option>
                                        @foreach($data['subscribes'] as $subscribe)
                                            <option value="{{ $subscribe->id }}">{{ $subscribe->getTranslateName(app()->getLocale()) .'( '.$subscribe->period.' ) '.__('site.months')  }}</option>
                                        @endforeach
                                    </select>
                                    <span id="add_subscribe_id_error" class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">@lang('site.add')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
