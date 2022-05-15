<div class="col-md-8">
    <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title">@lang('site.l_orders')</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('site.one_employees')</th>
                        <th>@lang('site.one_clients')</th>
                        <th>@lang('site.status')</th>
                        <th>@lang('site.total')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['latest_orders'] as $o)
                        <tr>
                            <td><a href="{{ route(env('DASH_URL').'.orders.show',$o->id) }}">{{ $o->id }}</a></td>
                            <td>
                                @if($o->employee)
                                    {!! '<a href="' . route(env('DASH_URL') . '.employees.show', $o->sales_person_id) . '">' . $o->employee->name . '</a>' !!}
                                @endif
                            </td>
                            <td>
                                @if($o->getClient())
                                    {!! '<a href="' . route(env('DASH_URL') . '.clients.show', $o->client_id) . '">' . $o->getClient()->name . '</a>' !!}
                                @endif
                            </td>
                            <td>{!! $o->getStatusLable() !!}</td>
                            <td>
                                {{ $o->total + 0 }}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <a href="{{ route(env('DASH_URL').'.orders.index') }}" class="btn btn-sm btn-secondary float-right">@lang('site.v_orders')</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>
