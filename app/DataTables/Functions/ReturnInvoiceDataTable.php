<?php

namespace App\DataTables\Functions;

use App\Models\Invoice;
use App\Models\ReturnInvoice;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReturnInvoiceDataTable extends DataTable
{
    private $invoice_id;

    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', 'dashboard.functions.return_invoices.partials._action')
            ->rawColumns(['action']);
    }

    public function query(ReturnInvoice $model)
    {
        $q = $model->newQuery();
        if ($this->invoice_id != 0) {
            $q->where('invoice_id', $this->invoice_id);
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
            Column::make('invoice_id')->title(__('site.invoice_id'))->data('invoice_id')->name('invoice_id'),
            Column::make('amount')->title(__('site.amount'))->data('amount')->name('amount'),
            Column::make('notes')->title(__('site.notes'))->data('notes')->name('notes'),
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
