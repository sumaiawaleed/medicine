<input type="hidden" name="id" value="{{ $form_data->id }}">
<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="name">
            <label for="name_edit_input">@lang('site.name')</label>
            <input id="name_edit_input" type="text" name="name" placeholder="@lang('site.name')" class="form-control"
                   value="{{ $form_data->name }}">
            <span id="name_edit_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="phone">
            <label for="phone_edit_input">@lang('site.phone')</label>
            <input id="phone_edit_input" type="tel" name="phone" placeholder="@lang('site.phone')" class="form-control"
                   value="{{ $form_data->phone }}">
            <span id="phone_edit_error" class="help-block"></span>
        </div>
    </div>


    <div class="col-md-12">
        <div class="form-group" id="email">
            <label for="email_edit_input">@lang('site.email')</label>
            <input id="email_edit_input" type="email" name="email" placeholder="@lang('site.email')" class="form-control"
                   value="{{ $form_data->email }}">
            <span id="email_edit_error" class="help-block"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <input type="file" name="image" id="image_file" class="image">
        </div>

        <div class="form-group">
            @php $image_path = isset($form_data) ? $form_data->image_path : asset('public/uploads/photo.svg'); @endphp
            <img class="image-preview" width="200" height="200" src="{{ $image_path }}">
        </div>
    </div>
</div>
