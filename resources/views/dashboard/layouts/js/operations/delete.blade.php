<script>
    function delete_row(id){
        swal({
            title: "@lang('site.confirm_delete')",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $('#delete-'+id).submit();
            } else {
            }
        });
    }

    function delete_process(actionurl,id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            url: actionurl,
            dataType: 'text',
            processData: false,
            contentType: false,
            success: function (data) {
                result = jQuery.parseJSON(data);
                if (result.success) {
                    $("{{ $table_id }}").DataTable().ajax.reload()
                    swal({
                        icon: 'success',
                        title: '{{ __('site.deleted_successfully') }}',
                        text: "",
                        type: "success",
                    });
                } else {
                    swal({
                        icon: 'error',
                        title: '{{ __('site.cannot_delete_item') }}',
                        text: "",
                        type: "error",
                    });
                }
            },
            error: function (data) {

            }
        });
        return false;
    }
</script>
