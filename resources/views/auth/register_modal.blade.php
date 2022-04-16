<div class="modal  fade" id="register-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title f-w-600">
                    @lang('site.register')
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form role="form" class="register-form" method="post" action="{{ route('post_register') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                    <div class="form_wrap">
                        <div class="row">
                            <div class="col-md-12 register_error_msgs">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="form_item">
                                    <h4 class="form_item_title">@lang('site.first_name')</h4>
                                    <input type="text" name="first_name" id="first_name_input"
                                           value="">
                                    <span id="first_name_error" class="help-block"></span>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div class="form_item">
                                    <h4 class="form_item_title">@lang('site.last_name')</h4>
                                    <input type="text" name="last_name" id="last_name_input"
                                           value="">
                                    <span id="last_name_error" class="help-block"></span>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div class="form_item">
                                    <h4 class="form_item_title">@lang('site.phone')</h4>
                                    <input type="tel" name="phone" id="phone_input" value="">
                                    <span id="phone_error" class="help-block"></span>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div class="form_item">
                                    <h4 class="form_item_title">@lang('site.email')</h4>
                                    <input type="tel" name="email" id="email_input" value="">
                                    <span id="email_error" class="help-block"></span>
                                </div>
                            </div>

                            <div class="col col-md-6">
                                <h3 class="form_item_title" data-text-color="#9199AC">@lang('site.gender')</h3>
                                <div class="radio_group">
                                    <ul class="ul_li">
                                        <li>
                                            <div class="radio_item clearfix">
                                                <input id="male" value="1"
                                                        type="radio"
                                                       name="gender">
                                                <label for="male">@lang('site.male')</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="radio_item clearfix">
                                                <input id="female" value="2"
                                                       type="radio"
                                                       name="gender">
                                                <label for="female">@lang('site.female')</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <img src="{{ asset('public/photo.svg') }}" class="image-preview" width="100">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="file" class="image" name="image" id="image_input"
                                               style="display: none">
                                        <button type="button" class="btn btn-sm btn-success"
                                                onclick="$('#image_input').click()"
                                                style="min-width: 100px;padding: 10px;">
                                            @lang('site.image')
                                        </button>
                                        <span id="image_error" class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn_danger">@lang('site.register')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
