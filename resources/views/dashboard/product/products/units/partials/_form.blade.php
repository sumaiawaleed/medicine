@php
    $unit_id = isset($form_data) ? $form_data->unit_id : '';
    $quantity = isset($form_data) ? $form_data->quantity : '';
    $price = isset($form_data) ? $form_data->price : '';
@endphp
<input type="hidden" value="{{ $data['product']->id }}" name="product_id">
<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="unit_id">
            <label
                for="unit_id_input">@lang('site.unit_id')</label>
            <select id="unit_id_input" name="unit_id"
                    class="form-control unit_id" style="width: 100%;">
                @foreach(__('vars.units') as $index=>$u)
                    <option {{ $unit_id == $index ? 'selected'  : '' }} value="{{ $index }}">{{ $u }}</option>
                @endforeach
            </select>
            <span id="unit_id_error" class="help-block"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="quantity">
            <label
                for="quantity_input">@lang('site.quantity')</label>
            <input class="form-control" type="number" name="quantity" id="quantity_input" value="{{ $quantity }}" placeholder="@lang('site.quantity')">
            <span id="quantity_error" class="help-block"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="price">
            <label
                for="price_input">@lang('site.price')</label>
            <input class="form-control" type="number" name="price" id="price_input" value="{{ ($price) ? date('Y-m-d',strtotime($price)) : '' }}" placeholder="@lang('site.price')">
            <span id="price_error" class="help-block"></span>
        </div>
    </div>
</div>
