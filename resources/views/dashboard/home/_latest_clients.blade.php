<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('site.l_clients')</h3>

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
               @foreach($data['latest_clients'] as $c)
                    <li>
                        <img style="width: 100px !important;height: 100px !important;" src="{{ $c->image_path }}" alt="User Image">
                        <a class="users-list-name" href="{{ route(env('DASH_URL').'.clients.show',$c->id) }}">
                            {{ $c->name }}
                        </a>
                        <span class="users-list-date">{{ $c->created_at }}</span>
                    </li>
                @endforeach
            </ul>
            <!-- /.users-list -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
            <a href="{{ route(env('DASH_URL').'.clients.index') }}">@lang('site.v_clients')</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>
