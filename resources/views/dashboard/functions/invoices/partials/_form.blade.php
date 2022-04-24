<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="client_id">
            <label
                for="client_id_input">@lang('site.client_id')</label>
            <select id="client_id_input" name="client_id"
                    class="form-control select2 client_id clients" style="width: 100%;">
                @if(isset($data['client']) and $data['client'])
                    <option selected value="{{ $data['client']->id }}">{{ $data['client']->name }}</option>
                @endif
            </select>
            <span id="client_id_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="sales_person_id">
            <label
                for="sales_person_id_input">@lang('site.sales_person_id')</label>
            <select id="sales_person_id_input" name="sales_person_id"
                    class="form-control select2 sales_person_id employess" style="width: 100%;">
                @if(isset($data['emp']) and $data['emp'])
                    <option selected value="{{ $data['emp']->id }}">{{ $data['emp']->name }}</option>
                @endif
            </select>
            <span id="sales_person_id_error" class="help-block"></span>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="order_id">
            <label
                for="order_id_input">@lang('site.order_id')</label>
            <select id="order_id_input" name="order_id"
                    class="form-control select2 order_id orders" style="width: 100%;">
                @if(isset($data['order']) and $data['order'])
                    <option selected value="{{ $data['order']->id }}">{{ $data['order']->id }}</option>
                @endif
            </select>
            <span id="order_id_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="type">
            <label
                for="type_input">@lang('site.type')</label>
            <select id="type_input" name="type"
                    class="form-control type" style="width: 100%;">
               <option value="">@lang('site.select') @lang('site.type')</option>
                @foreach(__('vars.invoices') as $index=>$t )
                    <option value="{{ $index }}">{{ $t }}</option>
                @endforeach
            </select>
            <span id="type_error" class="help-block"></span>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="total_div">
            <label
                for="total_input">@lang('site.total')</label>
            <input name="total" type="text" value=""
                   class="form-control" id="total_input"
                   placeholder="@lang('site.total')">
            <span id="total_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="tax_div">
            <label
                for="tax_input">@lang('site.tax')</label>
            <input name="tax" type="text" value=""
                   class="form-control" id="tax_input"
                   placeholder="@lang('site.tax')">
            <span id="tax_error" class="help-block"></span>
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
