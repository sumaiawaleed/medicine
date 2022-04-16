<input type="hidden" name="id" value="{{ $form_data->id }}">
<div class="row">
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-md-6">
            <div class="form-group" id="{{ $locale }}_area_name_edit_div">
                @php $name[$locale] = isset($form_data) ? $form_data->getTranslateName($locale) : ""; @endphp
                <label
                    for="{{ $locale }}_area_name_edit_input">@lang('site.' . $locale . '.name')</label>
                <input name="{{ $locale }}_area_name" type="text" value="{{ $name[$locale] }}"
                       class="form-control" id="{{ $locale }}_area_name_edit_input"
                       placeholder="@lang('site.' . $locale . '.name')">
                <span id="{{ $locale }}_area_name_edit_error" class="help-block"></span>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="city_id">
            <label
                for="city_id_edit_input">@lang('site.city_id')</label>
            <select id="city_id_edit_input" name="city_id"
                    class="form-control select2 city_id cities" style="width: 100%;">
                @if($data['city'])
                    <option value="{{ $data['city']->id }}" selected>{{ $data['city']->getTranslateName(app()->getLocale()) }}</option>
                @endif
            </select>
            <span id="city_id_edit_error" class="help-block"></span>
        </div>
    </div>
</div>
