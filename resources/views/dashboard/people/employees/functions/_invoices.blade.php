@extends('dashboard.people.employees.app')
@section('emp_content')

    @if (auth()->user()->hasPermission('invoices-create'))
        <button type="button" onclick="$('#create-model').modal('show')"
                class="btn btn-sm btn-success">
            @lang("site.add")
        </button>
    @endif

    {!! $dataTable->table() !!}


    @if (auth()->user()->hasPermission('invoices-create'))
        @include('dashboard.functions.invoices.create_model')
    @endif
    @if (auth()->user()->hasPermission('invoices-update'))
        @include('dashboard.functions.invoices.edit_model')
    @endif

@endsection
@push('styles')
    <link rel="stylesheet"
          href="{{ asset("public/dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
    <link rel="stylesheet"
          href="{{ asset("public/dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
    <link rel="stylesheet"
          href="{{ asset("public/dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset('public/dashboard/select2/dist/css/select2.min.css')}}">
@endpush

@push('scripts')
    @php $table_id = "table";
    @endphp
    @include('dashboard.layouts.js._print')
    @include('dashboard.layouts.js._table_form')
@endpush
