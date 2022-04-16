<script>
    $(".image").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.image-preview').attr('style', 'display: block');
                $('.image-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $(".image1").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.image-preview1').attr('style', 'display: block');
                $('.image-preview1').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@include('dashboard.layouts.js.operations.status')
@include('dashboard.layouts.js.operations.delete')
@include('dashboard.layouts.js.operations.create')
@include('dashboard.layouts.js.operations.edit')
