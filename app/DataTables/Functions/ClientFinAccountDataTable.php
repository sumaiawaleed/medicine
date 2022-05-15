<?php

namespace App\DataTables\Functions;

use App\Models\ClientFinAccount;
use App\Models\Invoice;
use App\Models\Receipt;
use App\Models\ReturnInvoice;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientFinAccountDataTable extends DataTable
{
    private $client_id;

    public function __construct($client_id)
    {
        $this->client_id = $client_id;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('client_name', function ($data) {
                if ($data->getClient()) {
                    return '<a href="' . route(env('DASH_URL') . '.clients.show', $data->client_id) . '">' . $data->getClient()->name . '</a>';
                } else {
                    return '';
                }
            })
            ->addColumn('action', 'dashboard.functions.client_fin_accounts.partials._action')
            ->rawColumns(['action','client_name']);
    }

    public function query(ClientFinAccount $model)
    {
        $q = $model->newQuery();
        if ($this->client_id != 0) {
            $q->where('client_id', $this->client_id);
        }
        return $q;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('print'),
                Button::make('reload')
            );
    }

    protected function getColumns()
    {
        return [
            Column::make('id')->title('#')->data('id')->name('id'),
            Column::make('client_name')->title(__('site.client_name'))->data('client_name')->name('client_name'),
            Column::make('total_amount')->title(__('site.total_amount'))->data('total_amount')->name('total_amount'),
            Column::make('paid_amount')->title(__('site.paid_amount'))->data('paid_amount')->name('paid_amount'),
            Column::make('remind_amount')->title(__('site.remind_amount'))->data('remind_amount')->name('remind_amount'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->title(__('site.action'))
                ->addClass('text-center')
        ];
    }

    protected function filename()
    {
        return 'Invoice_' . date('YmdHis');
    }
}
