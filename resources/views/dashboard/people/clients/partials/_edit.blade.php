@php
 $name = isset($form_data) ? $form_data->name : '';
 $email = isset($form_data) ? $form_data->email : '';
 $phone = isset($form_data) ? $form_data->phone : '';
 $client_type = isset($data['client']) ? $data['client']->type_id : 0;
@endphp
<input type="hidden" value="{{ $form_data->id }}" name="id">
<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="name">
            <label for="name_edit_input">@lang('site.name')</label>
            <input id="name_edit_input" type="text" name="name" placeholder="@lang('site.name')" class="form-control"
                   value="{{ $name }}">
            <span id="name_edit_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="email">
            <label for="email_edit_input">@lang('site.email')</label>
            <input id="email_edit_input" type="email" name="email" placeholder="@lang('site.email')" class="form-control"
                   value="{{ $email }}">
            <span id="email_edit_error" class="help-block"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="client_type">
            <label for="client_type_edit_input">@lang('site.client_type')</label>
            <select name="client_type" id="client_type_edit_input" class="form-control">
                <option value="">@lang('site.select') @lang('site.client_type')</option>
                @foreach($data['types'] as $type)
                    <option {{ $client_type == $type->id ? 'selected'  : '' }} value="{{ $type->id }}">{{ $type->getTranslateName(app()->getLocale()) }}</option>
                @endforeach
            </select>
            <span id="client_type_edit_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="phone">
            <label for="phone_edit_input">@lang('site.phone')</label>
            <input id="phone_edit_input" type="tel" name="phone" placeholder="@lang('site.phone')" class="form-control"
                   value="{{ $phone }}">
            <span id="phone_edit_error" class="help-block"></span>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="file" name="image" id="image_file" class="image">
        </div>

        <div class="form-group">
            @php $image_path = isset($form_data) ? $form_data->image_path : asset('public/uploads/photo.svg'); @endphp
            <img class="image-preview" width="200" height="200" src="{{ $image_path }}">
        </div>
    </div>
</div>
