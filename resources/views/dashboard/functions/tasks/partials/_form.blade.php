@php
    $lat = isset($form_data) ? $form_data->lat : 0;
    $log = isset($form_data) ? $form_data->log : 0;
    $name = isset($form_data) ? $form_data->name : '';
    $notes = isset($form_data) ? $form_data->notes : '';
    $location = isset($form_data) ? $form_data->location : '';
    $from_date = isset($form_data) ? $form_data->from_date : '';
    $to_date = isset($form_data) ? $form_data->to_date : '';
    $status = isset($form_data) ? $form_data->status : '';
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="name">
            <label for="name_input">@lang('site.name')</label>
            <input id="name_input" type="text" name="name" placeholder="@lang('site.name')" class="form-control"
                   value="{{ $name }}">
            <span id="name_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group" id="notes">
            <label for="notes_input">@lang('site.notes')</label>
            <textarea name="notes" id="notes_input" class="form-control"
                      placeholder="@lang('site.notes')">{{ $notes }}</textarea>
            <span id="notes_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="from_date">
            <label for="from_date_input">@lang('site.from_date')</label>
            <input id="from_date_input" type="date" name="from_date" placeholder="@lang('site.from_date')"
                   class="form-control"
                   value="{{ ($from_date) ? date('Y-m-d',strtotime($from_date)) : '' }}">
            <span id="from_date_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="to_date">
            <label for="to_date_input">@lang('site.to_date')</label>
            <input id="to_date_input" type="date" name="to_date" placeholder="@lang('site.to_date')"
                   class="form-control"
                   value="{{ ($to_date) ? date('Y-m-d',strtotime($to_date)) : '' }}">
            <span id="to_date_error" class="help-block"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="client_id">
            <label
                for="client_id_input">@lang('site.client_id')</label>
            <select id="client_id_input" name="client_id"
                    class="form-control select2 client_id clients" style="width: 100%;">
                @if(isset($data['client']) and $data['client'])
                    <option selected value="{{ $data['client']->id }}">{{ $data['client']->user ?  $data['client']->user->name : '' }}</option>
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
                    class="form-control select2 sales_person_id employees" style="width: 100%;">
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
        <div class="form-group" id="status">
            <label
                for="status_input">@lang('site.status')</label>
            <select id="status_input" name="status"
                    class="form-control status" style="width: 100%;">
                <option value="">@lang('site.select') @lang('site.status')</option>
                @foreach(__('vars.tasks') as $index=>$t)
                    <option {{ $status == $index ? 'selected' : '' }} value="{{ $index }}">{{ $t }}</option>
                @endforeach
            </select>
            <span id="status_error" class="help-block"></span>
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group" id="location">
            <label for="location_input">@lang('site.location')</label>
            <input id="location_input" type="text" name="location" placeholder="@lang('site.location')"
                   class="form-control"
                   value="{{ $location }}">
            <span id="location_error" class="help-block"></span>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="city_id">
            <label
                for="city_id_input">@lang('site.city_id')</label>
            <select id="city_id_input" name="city_id"
                    class="form-control select2 city_id cities" style="width: 100%;">
                @if(isset($data['city']) and $data['city'])
                    <option
                        value="{{ $data['city']->id }}">{{ $data['city']->getTranslateName(app()->getLocale()) }}</option>
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
                    <option
                        value="{{ $data['area']->id }}">{{ $data['area']->getTranslateName(app()->getLocale()) }}</option>
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

