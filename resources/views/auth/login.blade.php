<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="">
    <meta name="keywords"
          content="">
    <meta name="author" content="">
    <title>@lang('site.title')| @lang('site.login')</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('public/dashboard/css/font-awesome.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('public/dashboard/css/themify.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/dashboard/css/jsgrid.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/dashboard/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/dashboard/css/admin.css')}}">

</head>
<body>

<!-- page-wrapper Start-->
<div class="page-wrapper">
    <div class="authentication-box">
        <div class="container">
            <div class="row">
                <div class="col-md-12 p-0 card-right">
                    <div class="card tab2-card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="top-profile-tab" data-toggle="tab"
                                       href="#top-profile" role="tab" aria-controls="top-profile"
                                       aria-selected="true"><span class="icon-user mr-2"></span>@lang('site.login')</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
                                     aria-labelledby="top-profile-tab">
                                    <form class="form-horizontal auth-form" method="post"
                                          action="{{ route(env('DASH_URL').'.loginProcess') }}">
                                        {{ csrf_field() }}
                                        {{ method_field('post') }}
                                        <div class="form-group">
                                            <input required="" name="email" type="email" class="form-control"
                                                   placeholder="{{ __('site.email') }}" id="exampleInputEmail1">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input required="" name="password" type="password" class="form-control"
                                                   placeholder="@lang('site.password')">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-terms">
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="customControlAutosizing">
                                                <label class="custom-control-label" for="customControlAutosizing">Remember
                                                    me</label>
                                                <a href="#" class="btn btn-default forgot-pass">lost your password</a>
                                            </div>
                                        </div>
                                        <div class="form-button">
                                            <button class="btn btn-primary" type="submit">Login</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('public/dashboard/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('public/dashboard/js/popper.min.js')}}"></script>
<script src="{{ asset('public/dashboard/js/bootstrap.js')}}"></script>
<script src="{{ asset('public/dashboard/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{ asset('public/dashboard/js/icons/feather-icon/feather-icon.js')}}"></script>
<script src="{{ asset('public/dashboard/js/sidebar-menu.js')}}"></script>
<script src="{{ asset('public/dashboard/js/jsgrid/jsgrid.min.js')}}"></script>
<script src="{{ asset('public/dashboard/js/admin-script.js')}}"></script>
<script>
    $('.single-item').slick({
            arrows: false,
            dots: true
        }
    );
</script>
</body>
</html>
