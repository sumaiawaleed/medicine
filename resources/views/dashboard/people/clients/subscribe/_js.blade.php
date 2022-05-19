<script>
    function cancel_subscribe(id) {
        swal({
            title: "@lang('site.confirm_cancel')",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: "{{ route(env('DASH_URL').'.clients.subscribe.cancel') }}?id=" + id,
                    dataType: 'text',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        result = jQuery.parseJSON(data);
                        if (result.success) {
                            $("{{ $table_id }}").DataTable().ajax.reload()
                            swal({
                                icon: 'success',
                                title: '{{ __('site.canceled_successfully') }}',
                                text: "",
                                type: "success",
                            });
                        }
                    },
                    error: function (data) {

                    }
                });
                return false;
            } else {
            }
        });
    }

    function add_subscribe(id) {
        $('#add_sub_id').val(id);
        $('#add-sub-model').modal('show');
    }

    $(".form").submit(function (e) {
        e.preventDefault();
        btn = $(this).children('btn');
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
            beforeSend: function () {
                $('#value').show();
            },
            complete: function () {
                $('#value').hide();
                $('button').removeAttr('disabled');
            },
            success: function (data) {
                result = jQuery.parseJSON(data);

                if (result.success) {
                    @if(isset($type) and $type == 'edit')
                    swal({
                        icon: 'success',
                        title: '{{ __('site.updated_successfully') }}',
                        text: "",
                        type: "success",
                    });
                    $('#add-sub-model').modal('hide');
                    @else
                    swal({
                        icon: 'success',
                        title: '{{ __('site.added_successfully') }}',
                        text: "",
                        type: "success",
                    });
                    $('.form').trigger('reset');
                    @endif
                    $('.form-group').removeClass('has-error');
                    $('.help-block').text('');
                } else {
                    var errors = result.errors;
                    var html_errors = '<ul>';

                    $('#error').html('');
                    $.each(errors, function (key, val) {
                        key = key.replace('[', '');
                        key = key.replace(']', '');
                        key = key.replace('.', '');
                        $("#" + key + "_error").text(val[0]);
                        $("#" + key + "_div").addClass('has-error');
                        html_errors += "<li>" + val[0] + "<\li>";
                    });
                    html_errors += '</ul>';
                }
            },
            error: function (data) {

            }
        });
    });

</script>
