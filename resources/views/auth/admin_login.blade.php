<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ $settings->getTranslateTitle(app()->getLocale()) }}| @lang('site.login')</title>
    <link rel="stylesheet" href="{{ asset("public/dashboard/plugins/fontawesome-free/css/all.min.css")}}">
    <link rel="stylesheet" href="{{ asset("public/dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{ asset("public/dashboard/dist/css/adminlte.min.css")}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{ route('home') }}" class="h1">
                <img src="{{ $settings->image_path }}" alt="logo" height="150">
            </a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">
                @lang('site.login_msg')
            </p>

            <form action="{{ route(env('DASH_URL').'.loginProcess') }}" method="post">
                {{ csrf_field() }}
                {{ method_field('post') }}
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="{{ __('site.email') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="@lang('site.password')">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                @lang('site.remember_me')
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">@lang('site.login')</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset("public/dashboard/plugins/jquery/jquery.min.js")}}"></script>
<script src="{{ asset("public/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{ asset("public/dashboard/dist/js/adminlte.min.js")}}"></script>
</body>
</html>
