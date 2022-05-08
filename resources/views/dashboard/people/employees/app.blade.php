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
                            <li class="breadcrumb-item">
                                <a href="{{ route(env('DASH_URL').'.employees.index') }}">@lang('site.employees')</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $data['title'] }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{ $data['user']->image_path }}"
                                         alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ $data['user']->name }}</h3>

                                <p class="text-muted text-center">
                                <ul class="list-style-none">
                                    <li><i class="fa fa-phone"></i> {{ $data['user']->phone }}</li>
                                    <li><i class="fa fa-envelope"></i> {{ $data['user']->email }}</li>
                                </ul>
                                </p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>@lang('site.tasks')</b> <a class="float-right">{{ $data['tasks'] }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>@lang('site.orders')</b> <a class="float-right">{{ $data['orders'] }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>@lang('site.invoices')</b> <a class="float-right">{{ $data['invoices'] }}</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a href="{{ route(env('DASH_URL').'.employees.show',$data['user']->id) }}" class="nav-link {{ $data['page'] == 'edit' ? 'active' : '' }}">@lang('site.edit')</a>
                                    </li>
                                    <li class="nav-item"><a href="{{ route(env('DASH_URL').'.employee.orders',$data['user']->id) }}" class="nav-link {{ $data['page'] == 'orders' ? 'active' : '' }}" >@lang('site.orders')</a></li>
                                    <li class="nav-item"><a href="{{ route(env('DASH_URL').'.employee.invoices',$data['user']->id) }}" class="nav-link {{ $data['page'] == 'invoices' ? 'active' : '' }}">@lang('site.invoices')</a></li>
                                    <li class="nav-item"><a href="{{ route(env('DASH_URL').'.employee.tasks',$data['user']->id) }}" class="nav-link {{ $data['page'] == 'tasks' ? 'active' : '' }}">@lang('site.tasks')</a></li>
                                    <li class="nav-item"><a href="{{ route(env('DASH_URL').'.employee.locations',$data['user']->id) }}" class="nav-link {{ $data['page'] == 'locations' ? 'active' : '' }}">@lang('site.locations')</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        @yield('emp_content')
                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>

@endsection
