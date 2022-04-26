@extends('dashboard.people.employees.app')
@section('emp_content')

    {!! $dataTable->table() !!}

    @if (auth()->user()->hasPermission('orders-update'))
        @include('dashboard.functions.orders.edit_model')
    @endif

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
    @include('dashboard.layouts.js._table_form')
@endpush
