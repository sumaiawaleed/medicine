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
                                        <i class="fas fa-globe"></i> # {{ $data['title'] }}
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

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">
                                    <p class="lead">Payment Methods:</p>
                                    <img src="../../dist/img/credit/visa.png" alt="Visa">
                                    <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                                    <img src="../../dist/img/credit/american-express.png" alt="American Express">
                                    <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning
                                        heekya handango imeem
                                        plugg
                                        dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    <p class="lead">Amount Due 2/22/2014</p>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>$250.30</td>
                                            </tr>
                                            <tr>
                                                <th>Tax (9.3%)</th>
                                                <td>$10.34</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping:</th>
                                                <td>$5.80</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>$265.24</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                                            class="fas fa-print"></i> Print</a>
                                    <button type="button" class="btn btn-success float-right"><i
                                            class="far fa-credit-card"></i> Submit
                                        Payment
                                    </button>
                                    <button type="button" class="btn btn-primary float-right"
                                            style="margin-right: 5px;">
                                        <i class="fas fa-download"></i> Generate PDF
                                    </button>
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

