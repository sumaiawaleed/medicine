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
                                <a href="{{ route(env('DASH_URL').'.roles.index') }}">@lang('site.roles')</a>
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
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" class="form" method="post"
                          action="{{ route(env('DASH_URL').'.roles.update',0) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="box-body">
                            <input type="hidden" name="id" value="{{ $form_data->id }}">
                            @include('dashboard.people.roles.partials._form')
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

@push('scripts')
    @php $type = 'edit';@endphp
    @include('dashboard.layouts.js.form.create')
    <script>

        $('#permissions_all').on('change', function(e) {
            e.stopPropagation();

            if (e.target.checked) {
                $('input').prop( "checked", true );
            } else {
                $('input').prop( "checked", false );
            }
        });

        $('.container_check').on('change', function(e) {
            e.stopPropagation();
            var name = $(this).attr('data-model');
            if (e.target.checked) {
                $('.chk_' + name).prop( "checked", true );
            } else {
                $('.chk_' + name).prop( "checked", false );
            }
        });


    </script>
@endpush
