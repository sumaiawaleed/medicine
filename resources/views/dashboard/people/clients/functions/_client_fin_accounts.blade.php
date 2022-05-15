@extends('dashboard.people.clients.app')
@section('emp_content')

    @if (auth()->user()->hasPermission('client_fin_accounts-create'))
        <button type="button" onclick="$('#create-model').modal('show')"
                class="btn btn-sm btn-success">
            @lang("site.add")
        </button>
    @endif

    {!! $dataTable->table() !!}


    @if (auth()->user()->hasPermission('client_fin_accounts-create'))
        @include('dashboard.functions.client_fin_accounts.create_model')
    @endif
    @if (auth()->user()->hasPermission('client_fin_accounts-update'))
        @include('dashboard.functions.client_fin_accounts.edit_model')
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
