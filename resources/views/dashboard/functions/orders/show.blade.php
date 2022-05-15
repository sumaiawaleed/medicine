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
                                <a href="{{ route(env('DASH_URL').'.orders.index') }}">@lang('site.orders')</a>
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
                    <div class="col-12">
                        <div class="invoice p-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        # {{ $data['title'] }}
                                        <small class="float-right">@lang('site.date')
                                            : {{ $data['order']->created_at }}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    @if($data['order']->getClient())
                                        @lang('site.one_clients')
                                        <address>
                                            <strong>{{ $data['order']->getClient()->name }}</strong><br>
                                            @lang('site.phone') : {{ $data['order']->getClient()->phone }}<br>
                                            @lang('site.email') : {{ $data['order']->getClient()->email }}<br>
                                        </address>
                                    @endif
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    @if($data['order']->employee)
                                        @lang('site.one_employees')
                                        <address>
                                            <strong>{{ $data['order']->employee->name }}</strong><br>
                                            @lang('site.phone') : {{ $data['order']->employee->phone }}<br>
                                            @lang('site.email') : {{ $data['order']->employee->email }}<br>
                                        </address>
                                    @endif

                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>@lang('site.one_orders')</b><br>
                                    <b>@lang('site.order_id'):</b> {{ $data['order']->id }}<br>
                                    <b>@lang('site.total'):</b> {{ $data['order']->total }}<br>
                                    <b>@lang('site.status'):</b> {!! $data['order']->getStatusLable() !!}
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('site.one_products')</th>
                                            <th>@lang('site.scientific_name')</th>
                                            <th>@lang('site.image')</th>
                                            <th>@lang('site.quantity')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                       @foreach($data['items'] as $item)
                                           <tr>
                                               <td>{{ $item->id }}</td>
                                               <td>{{ $item->product ?  $item->product->getTranslateName(app()->getLocale()) : '' }}</td>
                                               <td>{{ $item->product ?  $item->product->scientific_name : '' }}</td>
                                               <td>
                                                   <img width="100" height="100" class="img-thumbnail" src="{{ $item->product ?  $item->product->image_path : asset('public/uploads/photo.svg') }}">
                                               </td>
                                               <td>{{ $item->quantity }}</td>
                                           </tr>
                                       @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>@lang('site.invoices')</h2>
                                </div>
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('site.one_clients')</th>
                                            <th>@lang('site.one_employees')</th>
                                            <th>@lang('site.total')</th>
                                            <th>@lang('site.tax')</th>
                                            <th>@lang('site.notes')</th>
                                            <th>@lang('site.type')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['invoices'] as $invoice)
                                            <tr>
                                                <td>{{ $invoice->id }}</td>
                                                <td>{{ $invoice->getClient() ?  $item->getClient()->name : '' }}</td>
                                                <td>{{ $invoice->employee ?  $invoice->employee->name : '' }}</td>
                                                <td>{{ $invoice->total + 0 }}</td>
                                                <td>{{ $invoice->tax + 0 }}</td>
                                                <td>{{ $invoice->notes }}</td>
                                                <td>{{ __('vars.invoices.'.$invoice->type) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <button onclick="window.print()" rel="noopener" target="_blank" class="btn btn-default"><i
                                            class="fas fa-print"></i> @lang('site.print')</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

    </div>
@endsection

