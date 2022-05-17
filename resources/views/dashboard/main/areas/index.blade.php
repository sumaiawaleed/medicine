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
                        @if (auth()->user()->hasPermission('areas-create'))
                            <button type="button" onclick="$('#create-model').modal('show')"
                                    class="btn btn-sm btn-success">
                                @lang("site.add")
                            </button>
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form class="mb-5">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="search" name="query" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <select  name="city_id"
                                        class="form-control select2 city_id cities" style="width: 100%;">
                                </select>                            </div>
                            <div class="col-md-4">
                                <input type="submit" class="btn btn-sm btn-success" value="{{ __('site.search') }}">
                            </div>
                        </div>
                    </form>

                    {!! $dataTable->table() !!}
                </div>
                <!-- /.card-body -->
            </div>
        </section>

    </div>

    @if (auth()->user()->hasPermission('areas-create'))
        @include('dashboard.main.areas.create_model')
    @endif
    @if (auth()->user()->hasPermission('areas-update'))
        @include('dashboard.main.areas.edit_model')
    @endif

@endsection
@push('styles')
    <link rel="stylesheet"
          href="{{ asset("public/dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
    <link rel="stylesheet"
          href="{{ asset("public/dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
    <link rel="stylesheet"
          href="{{ asset("public/dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset('public/dashboard/select2/dist/css/select2.min.css')}}">
@endpush

@push('scripts')
    @php $table_id = "table";
    $is_city = true;
    @endphp
    @include('dashboard.layouts.js._print')
    @include('dashboard.layouts.js._table_form')
    <script src="{{ asset('public/dashboard/select2/dist/js/select2.full.min.js')}}"></script>
    <script>
        @include('dashboard.layouts.js.auto_complete.cities')
    </script>
@endpush
