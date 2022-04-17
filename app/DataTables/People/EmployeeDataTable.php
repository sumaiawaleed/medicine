<?php

namespace App\DataTables\People;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image_path', function ($data) {
                return '<img src="'.$data->image_path.'" width="100px">';
            })
            ->addColumn('action', 'dashboard.people.employees.partials._action')
            ->rawColumns(['action','image_path']);
    }

    public function query(User $model)
    {
        $q = $model->newQuery();
        $q->where('type',2);
        $q->orderByDesc('id');
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
            Column::make('name')->title(__('site.name'))->data('name')->name('name'),
            Column::make('email')->title(__('site.email'))->data('email')->name('email'),
            Column::make('phone')->title(__('site.phone'))->data('phone')->name('phone'),
            Column::make('image_path')->title(__('site.image_path'))->data('image_path')->name('image_path'),
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
        return 'City_' . date('YmdHis');
    }
}
