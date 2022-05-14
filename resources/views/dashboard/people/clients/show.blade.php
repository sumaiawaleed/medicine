@extends('dashboard.people.clients.app')
@section('emp_content')
    <form enctype="multipart/form-data" class="form" role="form" method="post"
          action="{{ route(env('DASH_URL').'.clients.update',0) }}">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div id="edit_model_body">
            @include('dashboard.people.clients.partials._edit')
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
        </div>
    </form>
@endsection
@push('scripts')
    @php $type = "edit"; @endphp
    @include('dashboard.layouts.js.form.create')
@endpush
