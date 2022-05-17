<?php

namespace App\DataTables\Main;

use App\Models\City;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CityDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('name', function ($data) {
                return $data->getTranslateName(app()->getLocale());
            })
            ->addColumn('action', 'dashboard.main.cities.partials._action');
    }

    public function query(City $model)
    {
        $q = $model->newQuery();
        $q->orderByDesc('id');
        if ($this->request->get('query')) {
            $q->where('name', 'LIKE', '%' . $this->request->get('query') . '%');
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
                Button::make('export'),
                Button::make('print'),
                Button::make('reload')
            );
    }


    protected function getColumns()
    {
        return [
            Column::make('id')->title('#')->data('id')->name('id'),
            Column::make('name')->title(__('site.city_name'))->data('name')->name('name'),
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
