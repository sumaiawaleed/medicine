<div class="modal fade" id="check-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title f-w-600">
                    @lang('site.check')
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form role="form" class="check-form" method="post" action="{{ route('check_code') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                    <div class="box-body">
                        <div class="form_wrap">
                            <div class="row">
                                <div class="col-md-12 code_error_msgs">
                                </div>
                                <div class="col-md-12">
                                    <div class="form_item" id="verify_code">
                                        <h4 class="form_item_title">@lang('site.verify_code')*</h4>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="num1">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="num2">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="num3">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="num4">
                                            </div>
                                        </div>
                                        <span id="phone_error" class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center mt-5">
                            <button type="submit" class="btn btn_success btn_rounded">@lang('site.check')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(".check-form").submit(function (e) {

        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionurl = e.currentTarget.action;
        $.ajax({
            type: 'POST',
            url: actionurl,
            data: new FormData(this),
            dataType: 'text',
            processData: false,
            contentType: false,
            success: function (data) {
                result = jQuery.parseJSON(data);
                if (result.success == true) {
                    $('.check-form').trigger('reset');
                    $("#check-model").modal('hide');
                    location.reload();
                } else {
                    $('.code_error_msgs').addClass('login-alert');
                    $('.code_error_msgs').html("{{ __('site.code_error') }}");
                }
            },
            error: function (data) {

            }
        });
    });
</script>
