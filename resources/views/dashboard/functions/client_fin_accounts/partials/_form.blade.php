<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="total_amount_div">
            <label
                for="total_amount_input">@lang('site.total_amount')</label>
            <input name="total_amount" type="text" value=""
                   class="form-control" id="total_amount_input"
                   placeholder="@lang('site.total_amount')">
            <span id="total_amount_error" class="help-block"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="paid_amount_div">
            <label
                    for="paid_amount_input">@lang('site.paid_amount')</label>
            <input name="paid_amount" type="text" value=""
                   class="form-control" id="paid_amount_input"
                   placeholder="@lang('site.paid_amount')">
            <span id="paid_amount_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="remind_amount_div">
            <label
                for="remind_amount_input">@lang('site.remind_amount')</label>
            <input name="remind_amount" type="text" value=""
                   class="form-control" id="remind_amount_input"
                   placeholder="@lang('site.remind_amount')">
            <span id="remind_amount_error" class="help-block"></span>
        </div>
    </div>
</div>
