<div class="modal fade" id="login-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title f-w-600">
                    @lang('site.login')
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form role="form" class="login-form" method="post" action="{{ route('postLogin') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                    <div class="box-body">
                        <div class="form_wrap">
                            <div class="row">
                                <div class="col-md-12 login_error_msgs">
                                </div>
                                <div class="col-md-12">
                                    <div class="form_item" id="phone">
                                        <h4 class="form_item_title">@lang('site.phone')*</h4>
                                        <input type="text" name="phone">
                                        <span id="phone_error" class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center mt-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn_success btn_rounded">@lang('site.login')</button>
                                </div>
                                <div class="col-md-6">
                                    @lang('site.dont_have_account') {{ " " }}<a onclick="$('#login-model').modal('hide');$('#register-model').modal('show')" style="cursor: pointer"><b>@lang('site.register')</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
