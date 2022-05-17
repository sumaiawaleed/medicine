<?php

namespace App\DataTables\Functions;

use App\Models\Task;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TaskDataTable extends DataTable
{
    private $client_id;
    private $emp_id;

    public function __construct($client_id, $emp_id)
    {
        $this->emp_id = $emp_id;
        $this->client_id = $client_id;
    }


    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('status_name', function ($data) {
                return $data->getStatusLable();
            })
            ->addColumn('emp_name', function ($data) {
                if ($data->employee) {
                    return '<a href="' . route(env('DASH_URL') . '.employees.show', $data->sales_person_id) . '">' . $data->employee->name . '</a>';
                } else {
                    return '';
                }
            })->addColumn('client_name', function ($data) {
                if ($data->getClient()) {
                    return '<a href="' . route(env('DASH_URL') . '.clients.show', $data->client_id) . '">' . $data->getClient()->name . '</a>';
                } else {
                    return '';
                }
            })
            ->addColumn('action', 'dashboard.functions.tasks.partials._action')
            ->rawColumns(['action','client_name','emp_name','status_name']);
    }

    public function query(Task $model)
    {
        $q = $model->newQuery();
        $q->with(['client', 'employee']);
        if ($this->client_id != 0) {
            $q->where('client_id', $this->client_id);
        }

        if ($this->emp_id != 0) {
            $q->where('sales_person_id', $this->emp_id);
        }

        if ($this->request->get('client_id'))
            $q->where('client_id', $this->request->get('client_id'));
        if ($this->request->get('sales_person_id'))
            $q->where('sales_person_id', $this->request->get('sales_person_id'));

        if ($this->request->get('status'))
            $q->where('status', $this->request->get('status'));

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
                        Button::make('export'),
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
            Column::make('from_date')->title(__('site.from_date'))->data('from_date')->name('from_date'),
            Column::make('to_date')->title(__('site.to_date'))->data('to_date')->name('to_date'),
            Column::make('notes')->title(__('site.notes'))->data('notes')->name('notes'),
            Column::make('status_name')->title(__('site.status_name'))->data('status_name')->name('status_name'),
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
        return 'Task_' . date('YmdHis');
    }
}
