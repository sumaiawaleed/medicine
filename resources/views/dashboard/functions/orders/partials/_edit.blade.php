<input type="hidden" name="id" value="{{ $form_data->id }}">
<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="total_div">
            <label
                for="total_input">@lang('site.total')</label>
            <input name="total" type="text" value="{{ $form_data->total }}"
                   class="form-control" id="total_input"
                   placeholder="@lang('site.total')">
            <span id="total_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="status">
            <label
                for="status_input">@lang('site.status')</label>
            <select id="status_input" name="status"
                    class="form-control status" style="width: 100%;">
                <option value="">@lang('site.select') @lang('site.status')</option>
                @foreach(__('vars.orders') as $index=>$t )
                    <option {{ $form_data->status == $index ? 'selected'  : '' }} value="{{ $index }}">{{ $t }}</option>
                @endforeach
            </select>
            <span id="status_error" class="help-block"></span>
        </div>
    </div>


</div>
