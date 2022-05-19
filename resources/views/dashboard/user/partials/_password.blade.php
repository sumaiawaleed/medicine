<form class="form" method="post" enctype="multipart/form-data" action="{{ route(env('DASH_URL').'.profile.password') }}">
    {{ csrf_field() }}
    {{ method_field('post') }}
    <div class="row">
        <div class="col-md-6" id="old_password_edit_div">
            <div class="form-group">
                <label>@lang('site.old_password')</label>
                <input type="password" name="old_password" placeholder="@lang('site.old_password')"
                       class="form-control">
                <span id="old_password_edit_error" class="help-block"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group" id="password_edit_div">
                <label>@lang('site.password') الجديدة </label>
                <input type="password" name="password" placeholder="@lang('site.password') الجديدة"
                       class="form-control">
                <span id="password_edit_error" class="help-block"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group" id="password_confirmation_edit_div">
                <label>@lang('site.password_confirmation')</label>
                <input type="password" name="password_confirmation"
                       placeholder="@lang('site.password_confirmation')"
                       class="form-control">
                <span id="password_confirmation_edit_error" class="help-block"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <button type="submit" onclick="this.disabled = true; $(this).closest('form').submit()"
                        class="btn btn-primary">@lang('site.edit')</button>
            </div>
        </div>
    </div>
</form>
