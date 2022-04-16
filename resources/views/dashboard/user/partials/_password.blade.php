<form method="post" enctype="multipart/form-data" action="{{ route(env('DASH_URL').'.profile.password') }}" class="edit_form">
    {{ csrf_field() }}
    {{ method_field('post') }}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group" id="old_password_div">
                <label for="old_password_input">@lang('site.old_password')</label>
                <input id="old_password_input" type="password" name="old_password" placeholder="@lang('site.old_password')" class="form-control"
                       value="">
                <span id="old_password_error" class="help-block"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group" id="new_password_div">
                <label for="new_password_input">@lang('site.new_password')</label>
                <input id="new_password_input" type="password" name="new_password" placeholder="@lang('site.new_password')" class="form-control"
                       value="">
                <span id="new_password_error" class="help-block"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group" id="new_password_confirmation_div">
                <label for="new_password_confirmation_input">@lang('site.new_password_confirmation')</label>
                <input id="new_password_confirmation_input" type="password" name="new_password_confirmation" placeholder="@lang('site.new_password_confirmation')" class="form-control"
                       value="">
                <span id="new_password_confirmation_error" class="help-block"></span>
            </div>
        </div>
    </div>

        <div class="row">
            <div class="form-group">
                <button type="submit" onclick="this.disabled = true; $(this).closest('form').submit()"
                        class="btn btn-primary"><?php echo $submitButton ?? __('site.edit');?></button>
            </div>
        </div>
</form>
