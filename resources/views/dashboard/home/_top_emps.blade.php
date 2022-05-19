<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('site.top_emps')</h3>

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
            <ul class="users-list clearfix">
               @foreach($data['top_emps'] as $emp)
                    <li>
                        <img style="width: 100px !important;height: 100px !important;" src="{{ asset('public/uploads/users/'.$emp->image) }}" alt="User Image">
                        <a class="users-list-name" href="{{ route(env('DASH_URL').'.employees.show',$emp->id) }}">
                            {{ $emp->name }}
                        </a>
                        <span class="users-list-date">{{ $emp->total_orders }}</span>
                    </li>
                @endforeach
            </ul>
            <!-- /.users-list -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
            <a href="{{ route(env('DASH_URL').'.employees.index') }}">@lang('site.v_clients')</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>
