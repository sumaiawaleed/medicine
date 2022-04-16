<div class="row">
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-md-6">
            <div class="form-group" id="{{ $locale }}_category_name_div">
                @php $name[$locale] = isset($form_data) ? $form_data->getTranslateName($locale) : ""; @endphp
                <label
                    for="{{ $locale }}_category_name_input">@lang('site.' . $locale . '.category_name')</label>
                <input name="{{ $locale }}_category_name" type="text" value="{{ $name[$locale] }}"
                       class="form-control" id="{{ $locale }}_category_name_input"
                       placeholder="@lang('site.' . $locale . '.name')">
                <span id="{{ $locale }}_category_name_error" class="help-block"></span>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="parent_id">
            <label
                for="parent_id_input">@lang('site.parent_id')</label>
            <select id="parent_id_input" name="parent_id"
                    class="form-control select2 parent_id parents" style="width: 100%;">
            </select>
            <span id="parent_id_error" class="help-block"></span>
        </div>
    </div>
</div>
