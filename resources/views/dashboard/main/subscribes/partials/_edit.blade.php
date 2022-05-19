@php
    $price = isset($form_data) ? $form_data->price : '';
    $period = isset($form_data) ? $form_data->period : '';
@endphp
<input type="hidden" name="id" value="{{ $form_data->id }}">
<div class="row">
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-md-6">
            <div class="form-group" id="{{ $locale }}_name_edit_div">
                @php $name[$locale] = isset($form_data) ? $form_data->getTranslateName($locale) : ""; @endphp
                <label
                    for="{{ $locale }}_name_edit_input">@lang('site.' . $locale . '.name')</label>
                <input name="{{ $locale }}_name" type="text" value="{{ $name[$locale] }}"
                       class="form-control" id="{{ $locale }}_name_edit_input"
                       placeholder="@lang('site.' . $locale . '.name')">
                <span id="{{ $locale }}_name_edit_error" class="help-block"></span>
            </div>
        </div>
    @endforeach
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-md-12">
            <div class="form-group" id="{{ $locale }}_description_edit_div">
                @php $name[$locale] = isset($form_data) ? $form_data->getTranslateDesc($locale) : ""; @endphp
                <label
                    for="{{ $locale }}_description_edit_input">@lang('site.' . $locale . '.description')</label>
                <textarea name="{{ $locale }}_description" type="text"
                          class="form-control" id="{{ $locale }}_description_edit_input"
                          placeholder="@lang('site.' . $locale . '.name')">{{ $name[$locale] }}</textarea>
                <span id="{{ $locale }}_description_edit_error" class="help-block"></span>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="price">
            <label
                for="price_edit_input">@lang('site.price')</label>
            <input class="form-control" type="number" name="price" id="price_edit_input" value="{{ $price }}" placeholder="@lang('site.price')">
            <span id="price_edit_error" class="help-block"></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group" id="period">
            <label
                for="period_edit_input">@lang('site.period')</label>
            <input class="form-control" type="number" name="period" id="period_edit_input" value="{{ $period }}" placeholder="@lang('site.period')">
            <span id="period_edit_error" class="help-block"></span>
        </div>
    </div>
</div>

