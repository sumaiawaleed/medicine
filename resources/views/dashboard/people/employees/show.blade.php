@extends('dashboard.people.employees.app')
@section('emp_content')
    <form enctype="multipart/form-data" id="edit_new_form" role="form" method="post"
          action="{{ route(env('DASH_URL').'.employees.update',0) }}">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div id="edit_model_body">
            @include('dashboard.people.employees.partials._edit')
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
        </div>
    </form>
@endsection
