@extends('dashboard.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $data['title'] }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route(env('DASH_URL').'.index') }}">@lang('site.home')</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $data['title'] }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $data['title'] }}</h3>
                    <div class="card-tools">
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="edit_new_form" method="post" action="{{ route(env('DASH_URL').'.settings') }}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('post') }}
                        <div class="row">
                            @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
                                <div class="col-md-6">
                                    <div class="form-group" id="{{ $locale }}_title_div">
                                        @php $title[$locale] = isset($form_data) ? $form_data->getTranslateTitle($locale) : ""; @endphp
                                        <label
                                            for="{{ $locale }}_title_input">@lang('site.' . $locale . '.title')</label>
                                        <input name="{{ $locale }}_title" type="text" value="{{ $title[$locale] }}"
                                               class="form-control" id="{{ $locale }}_title_input"
                                               placeholder="@lang('site.' . $locale . '.title')">
                                        <span id="{{ $locale }}_title_error" class="help-block"></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row">
                            @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
                                <div class="col-md-6">
                                    <div class="form-group" id="{{ $locale }}_author_div">
                                        @php $author[$locale] = isset($form_data) ? $form_data->getTranslateAuthor($locale) : ""; @endphp
                                        <label
                                            for="{{ $locale }}_author_input">@lang('site.' . $locale . '.author')</label>
                                        <input name="{{ $locale }}_author" type="text"
                                               value="{{ $author[$locale] }}"
                                               class="form-control" id="{{ $locale }}_author_input"
                                               placeholder="@lang('site.' . $locale . '.author')">
                                        <span id="{{ $locale }}_author_error" class="help-block"></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row">
                            @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
                                <div class="col-md-6">
                                    <div class="form-group" id="{{ $locale }}_description_div">
                                        @php $description[$locale] = isset($form_data) ? $form_data->getTranslateDesc($locale) : ""; @endphp
                                        <label
                                            for="{{ $locale }}_description_input">@lang('site.' . $locale . '.description')</label>
                                        <input name="{{ $locale }}_description" type="text"
                                               value="{{ $description[$locale] }}"
                                               class="form-control" id="{{ $locale }}_description_input"
                                               placeholder="@lang('site.' . $locale . '.description')">
                                        <span id="{{ $locale }}_description_error" class="help-block"></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="facebook">
                                    <label for="facebook_input">@lang('site.facebook')</label>
                                    <input id="facebook_input" type="url" name="facebook"
                                           placeholder="@lang('site.facebook')" class="form-control"
                                           value="{{ $form_data->facebook }}">
                                    <span id="facebook_error" class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" id="twitter">
                                    <label for="twitter_input">@lang('site.twitter')</label>
                                    <input id="twitter_input" type="url" name="twitter"
                                           placeholder="@lang('site.twitter')" class="form-control"
                                           value="{{ $form_data->twitter }}">
                                    <span id="twitter_error" class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" id="linkedin">
                                    <label for="linkedin_input">@lang('site.linkedin')</label>
                                    <input id="linkedin_input" type="url" name="linkedin"
                                           placeholder="@lang('site.linkedin')" class="form-control"
                                           value="{{ $form_data->linkedin }}">
                                    <span id="linkedin_error" class="help-block"></span>
                                </div>

                                <button type="submit" class="btn btn-primary">@lang('site.edit')</button>


                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </section>

    </div>
@endsection
@push('scripts')
    <script>
        $("#edit_new_form").submit(function (e) {
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
                    $('button').removeAttr('disabled');
                },
                success: function (data) {
                    result = jQuery.parseJSON(data);
                    if (result.success) {
                        swal({
                            icon: 'success',
                            title: '{{ __('site.updated_successfully') }}',
                            text: "",
                            type: "success",
                        });
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

                        $('#result_error').html(html_errors);
                    }
                },
                error: function (data) {

                }
            });
        });
    </script>
@endpush
