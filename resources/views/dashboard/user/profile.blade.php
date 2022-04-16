@extends('dashboard.layouts.app')
@section('content')
    <div class="page-body">

        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <div class="page-header-left">
                            <h3>{{ $data['title'] }}</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ol class="breadcrumb pull-right">
                            <li class="breadcrumb-item"><a href="{{ route(env('DASH_URL').'.index') }}"><i
                                        data-feather="home"></i></a></li>
                            <li class="breadcrumb-item active">{{ $data['title'] }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card tab2-card">
                <div class="card-header">
                    <h5>{{ $data['title'] }}</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active show" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true" data-original-title="" title="">@lang('site.profile')</a></li>
                        <li class="nav-item"><a class="nav-link" id="restriction-tabs" data-toggle="tab" href="#restriction" role="tab" aria-controls="restriction" aria-selected="false" data-original-title="" title="">@lang('site.change_password')</a></li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                            @include('dashboard.user.partials._edit')
                        </div>
                        <div class="tab-pane fade" id="restriction" role="tabpanel" aria-labelledby="restriction-tabs">
                            @include('dashboard.user.partials._password')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @include('dashboard.layouts.js.form._edit_form')
@endpush
