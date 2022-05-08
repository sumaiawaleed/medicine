@extends('dashboard.people.employees.app')
@section('emp_content')

    @if (auth()->user()->hasPermission('locations-create'))
        <a href="{{ route(env('DASH_URL').'.locations.create',['emp_id' => $data['user']->id]) }}"
                class="btn btn-sm btn-success">
            @lang("site.add")
        </a>
    @endif

    {!! $dataTable->table() !!}

@endsection
@push('styles')
    <link rel="stylesheet"
          href="{{ asset("public/dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
    <link rel="stylesheet"
          href="{{ asset("public/dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
    <link rel="stylesheet"
          href="{{ asset("public/dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
@endpush

@push('scripts')
    @php $table_id = "table";
    @endphp
    @include('dashboard.layouts.js._print')
@endpush
