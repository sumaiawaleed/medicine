<?php

namespace App\DataTables\Functions;

use App\Models\Invoice;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
{
    private $client_id;
    private $emp_id;
    private $order_id;

    public function __construct($client_id, $emp_id,$order_id)
    {
        $this->emp_id = $emp_id;
        $this->client_id = $client_id;
        $this->order_id = $order_id;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('invoice_type', function ($data) {
                return __('vars.invoices.'.$data->type);
            })->addColumn('emp_name', function ($data) {
                if ($data->employee) {
                    return '<a href="'.route(env('DASH_URL').'.employees.show',$data->sales_person_id).'">'.$data->employee->name.'</a>';
                } else {
                    return '';
                }
            })->addColumn('client_name', function ($data) {
                if ($data->getClient()) {
                    return '<a href="'.route(env('DASH_URL').'.clients.show',$data->client_id).'">'.$data->getClient()->name.'</a>';
                } else {
                    return '';
                }
            })
            ->addColumn('action', 'dashboard.functions.invoices.partials._action')
            ->rawColumns(['action','client_name','emp_name']);
    }

    public function query(Invoice $model)
    {
        $q = $model->newQuery();
        $q->with(['employee']);
        if ($this->client_id != 0) {
            $q->where('client_id', $this->client_id);
        }

        if ($this->emp_id != 0) {
            $q->where('sales_person_id', $this->emp_id);
        }

        if ($this->order_id != 0) {
            $q->where('order_id', $this->order_id);
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
            Column::make('emp_name')->title(__('site.emp_name'))->data('emp_name')->name('emp_name'),
            Column::make('order_id')->title(__('site.order_id'))->data('order_id')->name('order_id'),
            Column::make('total')->title(__('site.total'))->data('total')->name('total'),
            Column::make('tax')->title(__('site.tax'))->data('tax')->name('tax'),
            Column::make('invoice_type')->title(__('site.invoice_type'))->data('invoice_type')->name('invoice_type'),
            Column::make('notes')->title(__('site.notes'))->data('notes')->name('notes'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->title(__('site.action'))
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Invoice_' . date('YmdHis');
    }
}
