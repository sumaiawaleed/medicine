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
                            @if($data['user']->type == 2)
                                <li class="breadcrumb-item">
                                    <a href="{{ route(env('DASH_URL').'.employee.locations',$data['user']->id) }}">{{ $data['user']->name }} @lang('site.locations')</a>
                                </li>
                            @endif
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
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" class="form" method="post"
                          action="{{ route(env('DASH_URL').'.locations.update',0) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="box-body">
                            <input type="hidden" name="id" value="{{ $form_data->id }}">
                            @include('dashboard.main.locations.partials._form')
                            <div class="box-footer">
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/dashboard/select2/dist/css/select2.min.css')}}">
@endpush
@push('scripts')
    @php
        $data['lat'] = isset($form_data) ? $form_data->lat : 0;
        $data['log'] = isset($form_data) ? $form_data->log : 0;
        $type = 'edit';
    @endphp
    @include('dashboard.layouts.js.form.create')
    @include('dashboard.layouts.js._map')
    <script src="{{ asset('public/dashboard/select2/dist/js/select2.full.min.js')}}"></script>
    <script>
        @include('dashboard.layouts.js.auto_complete.cities')
        @include('dashboard.layouts.js.auto_complete.areas')
    </script>
@endpush
