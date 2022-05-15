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
                            <li class="breadcrumb-item active">{{ $data['title'] }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
            @include('dashboard.home._counter')
{{--            @include('dashboard.home._orders')--}}

            <!-- Main row -->
                <div class="row">
                    @include('dashboard.home._latest_orders')
                    @include('dashboard.home._latest_clients')
                </div>

                <div class="row">
                    @include('dashboard.home._pending_tasks')
                    @include('dashboard.home._top_emps')
                    @include('dashboard.home._top_products')
                </div>
                <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>

    </div>
@endsection
@push('scripts')
    <script src="{{ asset("public/dashboard/plugins/jquery-mousewheel/jquery.mousewheel.js")}}"></script>
    <script src="{{ asset("public/dashboard/plugins/raphael/raphael.min.js")}}"></script>
    <script src="{{ asset("public/dashboard/plugins/jquery-mapael/jquery.mapael.min.js")}}"></script>
    <script src="{{ asset("public/dashboard/plugins/jquery-mapael/maps/usa_states.min.js")}}"></script>
    <script src="{{ asset("public/dashboard/plugins/chart.js/Chart.min.js")}}"></script>
@endpush
