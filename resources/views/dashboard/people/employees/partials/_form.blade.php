<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="name">
            <label for="name_input">@lang('site.name')</label>
            <input id="name_input" type="text" name="name" placeholder="@lang('site.name')" class="form-control"
                   value="">
            <span id="name_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="phone">
            <label for="phone_input">@lang('site.phone')</label>
            <input id="phone_input" type="tel" name="phone" placeholder="@lang('site.phone')" class="form-control"
                   value="">
            <span id="phone_error" class="help-block"></span>
        </div>
    </div>


    <div class="col-md-12">
        <div class="form-group" id="email">
            <label for="email_input">@lang('site.email')</label>
            <input id="email_input" type="email" name="email" placeholder="@lang('site.email')" class="form-control"
                   value="">
            <span id="email_error" class="help-block"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group" id="password">
            <label for="password_input">@lang('site.password')</label>
            <input id="password_input" type="password" name="password" placeholder="@lang('site.password')" class="form-control"
                   value="">
            <span id="password_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="password_confirmation">
            <label for="password_confirmation_input">@lang('site.password_confirmation')</label>
            <input id="password_confirmation_input" type="password" name="password_confirmation" placeholder="@lang('site.password_confirmation')" class="form-control"
                   value="">
            <span id="password_confirmation_error" class="help-block"></span>
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
