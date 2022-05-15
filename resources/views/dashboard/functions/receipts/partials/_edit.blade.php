<input type="hidden" value="{{ $form_data->id }}" name="id">
<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="total_edit_div">
            <label
                for="total_edit_input">@lang('site.total')</label>
            <input name="total" type="text" value="{{ $form_data->total }}"
                   class="form-control" id="total_edit_input"
                   placeholder="@lang('site.total')">
            <span id="total_edit_error" class="help-block"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="paid_amount_edit_div">
            <label
                for="paid_amount_edit_input">@lang('site.paid_amount')</label>
            <input name="paid_amount" type="text" value="{{ $form_data->paid_amount }}"
                   class="form-control" id="paid_amount_edit_input"
                   placeholder="@lang('site.paid_amount')">
            <span id="paid_amount_edit_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="remind_amount_edit_div">
            <label
                for="remind_amount_edit_input">@lang('site.remind_amount')</label>
            <input name="remind_amount" type="text" value="{{ $form_data->remind_amount }}"
                   class="form-control" id="remind_amount_edit_input"
                   placeholder="@lang('site.remind_amount')">
            <span id="remind_amount_edit_error" class="help-block"></span>
        </div>
    </div>
</div>
