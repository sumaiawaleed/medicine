<input type="hidden" value="{{ $form_data->id }}" name="id">
<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="amount_div">
            <label
                for="amount_edit_input">@lang('site.amount')</label>
            <input name="amount" type="text" value="{{ $form_data->amount }}"
                   class="form-control" id="amount_edit_input"
                   placeholder="@lang('site.amount')">
            <span id="amount_edit_error" class="help-block"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="notes_div">
            <label
                for="notes_edit_input">@lang('site.notes')</label>
            <textarea class="form-control" name="notes" id="notes_edit_input">{{ $form_data->notes }}</textarea>
            <span id="notes_edit_error" class="help-block"></span>
        </div>
    </div>
</div>
