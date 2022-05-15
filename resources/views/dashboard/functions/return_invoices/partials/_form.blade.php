<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="amount_div">
            <label
                    for="amount_input">@lang('site.amount')</label>
            <input name="amount" type="text" value=""
                   class="form-control" id="amount_input"
                   placeholder="@lang('site.amount')">
            <span id="amount_error" class="help-block"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="notes_div">
            <label
                for="notes_input">@lang('site.notes')</label>
            <textarea class="form-control" name="notes" id="notes_input"></textarea>
            <span id="notes_error" class="help-block"></span>
        </div>
    </div>
</div>
