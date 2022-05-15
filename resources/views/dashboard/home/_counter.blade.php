<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        @if (auth()->user()->hasPermission('orders-read'))
            <a href="{{ route(env('DASH_URL').'.orders.index') }}">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-basket"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('site.orders')</span>
                        <span class="info-box-number">
                  {{ $data['orders'] }}
                </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        @endif
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        @if (auth()->user()->hasPermission('invoices-read'))
            <a href="{{ route(env('DASH_URL').'.invoices.index') }}">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('site.invoices')</span>
                        <span class="info-box-number">{{ $data['invoices'] }}</span>
                    </div>
                </div>
            </a>
        @endif
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
        @if (auth()->user()->hasPermission('tasks-read'))
            <a href="{{ route(env('DASH_URL').'.tasks.index') }}">
                <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i
                                    class="fas fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">@lang('site.tasks')</span>
                        <span class="info-box-number">{{ $data['tasks'] }}</span>
                    </div>
                </div>
            </a>
        @endif
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        @if (auth()->user()->hasPermission('clients-read'))
            <a href="{{ route(env('DASH_URL').'.clients.index') }}">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('site.clients')</span>
                        <span class="info-box-number">{{ $data['clients'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        @endif
    </div>
    <!-- /.col -->
</div>
