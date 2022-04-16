<div class="row">
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-md-6">
            <div class="form-group" id="{{ $locale }}_city_name_div">
                @php $name[$locale] = isset($form_data) ? $form_data->getTranslateName($locale) : ""; @endphp
                <label
                    for="{{ $locale }}_city_name_input">@lang('site.' . $locale . '.city_name')</label>
                <input name="{{ $locale }}_city_name" type="text" value="{{ $name[$locale] }}"
                       class="form-control" id="{{ $locale }}_city_name_input"
                       placeholder="@lang('site.' . $locale . '.name')">
                <span id="{{ $locale }}_city_name_error" class="help-block"></span>
            </div>
        </div>
    @endforeach
</div>

