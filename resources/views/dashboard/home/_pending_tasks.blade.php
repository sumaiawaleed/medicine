<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="ion ion-clipboard mr-1"></i>
                @lang('site.p_tasks')
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <ul class="todo-list" data-widget="todo-list">
                @foreach($data['p_tasks'] as $task)
                <li>
                    <!-- drag handle -->
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <!-- todo text -->
                    <span class="text">
                        {{ $task->name }}
                    </span>
                    <!-- Emphasis label -->
                    <small class="badge badge-success"><i class="far fa-clock"></i> {{ $task->from_date }}</small>
                    <small class="badge badge-danger"><i class="far fa-clock"></i> {{ $task->to_date }} </small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                        <a href="{{ route(env('DASH_URL').'.tasks.edit',$task->id) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <a href="{{ route(env('DASH_URL').'.tasks.create') }}" type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> @lang("site.add") @lang("site.one_tasks")</a>
        </div>
    </div>
</div>
