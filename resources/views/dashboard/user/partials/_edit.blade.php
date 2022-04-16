<form method="post" enctype="multipart/form-data" action="{{ route(env('DASH_URL').'.profile') }}" class="edit_form">
    {{ csrf_field() }}
    {{ method_field('post') }}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group" id="name_div">
                <label for="name_input">@lang('site.name')</label>
                <input id="name_input" type="text" name="name" placeholder="@lang('site.name')" class="form-control"
                       value="{{ auth()->user()->name }}">
                <span id="name_error" class="help-block"></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group" id="email_div">
                <label for="email_input">@lang('site.email')</label>
                <input id="email_input" type="text" name="email" placeholder="@lang('site.email')" class="form-control"
                       value="{{ auth()->user()->email }}">
                <span id="email_error" class="help-block"></span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <input type="file" name="image" id="image_file" class="image">
            </div>

            <div class="form-group">
                @php $image_path = (auth()->user()->image_path) ? auth()->user()->image_path : asset('public/uploads/photo.svg'); @endphp
                <img class="image-preview" width="200" height="200" src="{{ $image_path }}">
            </div>
        </div>

        <div class="form-group">
            <button type="submit" onclick="this.disabled = true; $(this).closest('form').submit()"
                    class="btn btn-primary"><?php echo $submitButton ?? __('site.edit');?></button>
        </div>
    </div>
</form>
