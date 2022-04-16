@php
    $lat = isset($form_data) ? $form_data->lat : 0;
    $log = isset($form_data) ? $form_data->log : 0;
@endphp
<div class="row">
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <div class="col-md-6">
            <div class="form-group" id="{{ $locale }}_address_div">
                @php $name[$locale] = isset($form_data) ? $form_data->getTranslateAddress($locale) : ""; @endphp
                <label
                    for="{{ $locale }}_address_input">@lang('site.' . $locale . '.address')</label>
                <input name="{{ $locale }}_address" type="text" value="{{ $name[$locale] }}"
                       class="form-control" id="{{ $locale }}_address_input"
                       placeholder="@lang('site.' . $locale . '.name')">
                <span id="{{ $locale }}_address_error" class="help-block"></span>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="city_id">
            <label
                for="city_id_input">@lang('site.city_id')</label>
            <select id="city_id_input" name="city_id"
                    class="form-control select2 city_id cities" style="width: 100%;">
                @if(isset($data['city']) and $data['city'])
                    <option value="{{ $data['city']->id }}">{{ $data['city']->getTranslateName(app()->getLocale()) }}</option>
                @endif
            </select>
            <span id="city_id_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="area_id">
            <label
                for="area_id_input">@lang('site.area_id')</label>
            <select id="area_id_input" name="area_id"
                    class="form-control select2 area_id areas" style="width: 100%;">
                @if(isset($data['area']) and $data['area'])
                    <option value="{{ $data['area']->id }}">{{ $data['area']->getTranslateName(app()->getLocale()) }}</option>
                @endif
            </select>
            <span id="area_id_error" class="help-block"></span>
        </div>
    </div>

</div>

<div class="row">
    <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
    <input type="hidden" name="log" id="log" value="{{ $log }}">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="height: 300px;" id="map"></div>
</div>
