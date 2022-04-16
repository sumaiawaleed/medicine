@php
    $scientific_name = isset($form_data) ? $form_data->scientific_name : '';
    $expire_date = isset($form_data) ? $form_data->expire_date : '';
    $notes = isset($form_data) ? $form_data->notes : '';
    $is_available = isset($form_data) ? $form_data->is_available : '';
@endphp
<div class="row">
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-md-6">
            <div class="form-group" id="{{ $locale }}_product_name_div">
                @php $name[$locale] = isset($form_data) ? $form_data->getTranslateName($locale) : ""; @endphp
                <label
                    for="{{ $locale }}_product_name_input">@lang('site.' . $locale . '.product_name')</label>
                <input name="{{ $locale }}_product_name" type="text" value="{{ $name[$locale] }}"
                       class="form-control" id="{{ $locale }}_product_name_input"
                       placeholder="@lang('site.' . $locale . '.name')">
                <span id="{{ $locale }}_product_name_error" class="help-block"></span>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="scientific_name">
            <label
                for="scientific_name_input">@lang('site.scientific_name')</label>
            <input class="form-control" type="text" name="scientific_name" id="scientific_name_input" value="{{ $scientific_name }}" placeholder="@lang('site.scientific_name')">
            <span id="scientific_name_error" class="help-block"></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group" id="expire_date">
            <label
                for="expire_date_input">@lang('site.expire_date')</label>
            <input class="form-control" type="date" name="expire_date" id="expire_date_input" value="{{ ($expire_date) ? date('Y-m-d',strtotime($expire_date)) : '' }}" placeholder="@lang('site.expire_date')">
            <span id="expire_date_error" class="help-block"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="parent_id">
            <label
                for="parent_id_input">@lang('site.parent_id')</label>
            <select onchange="get_categories(value)" id="parent_id_input" name="parent_id"
                    class="form-control select2 parent_id parents" style="width: 100%;">
                @if(isset($data['parent']) and $data['parent'])
                    <option value="{{ $data['parent']->id }}">{{ $data['parent']->getTranslateName(app()->getLocale()) }}</option>
                @endif
            </select>
            <span id="parent_id_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="category_id">
            <label
                for="category_id_input">@lang('site.category_id')</label>
            <select id="category_id_input" name="category_id"
                    class="form-control select2 category_id categories" style="width: 100%;">
                @if(isset($data['category']) and $data['category'])
                    <option value="{{ $data['category']->id }}">{{ $data['category']->getTranslateName(app()->getLocale()) }}</option>
                @endif
            </select>
            <span id="category_id_error" class="help-block"></span>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="notes">
            <label
                for="notes_input">@lang('site.notes')</label>
            <textarea class="form-control" name="notes" id="notes_input" placeholder="@lang('site.notes')">{{ $notes }}</textarea>
            <span id="notes_error" class="help-block"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group" id="is_available">
            <label
                for="is_available_input">@lang('site.is_available')</label>
           <input type="checkbox" value="1" name="is_available" id="is_available_input" {{ $is_available == 1 ? 'checked' : '' }}>
            <span id="is_available_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-8">
        <div class="form-group">
            <input type="file" name="image" id="image_file" class="image">
        </div>

        <div class="form-group">
            @php $image_path = isset($form_data) ? $form_data->image_path : asset('public/uploads/photo.svg'); @endphp
            <img class="image-preview" width="200" height="200" src="{{ $image_path }}">
        </div>
    </div>

</div>
