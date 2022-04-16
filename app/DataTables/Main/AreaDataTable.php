<?php

namespace App\DataTables\Main;

use App\Models\Area;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AreaDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('city_name',function ($data){
                if($data->city){
                    return $data->city->getTranslateName(app()->getLocale());
                }else{
                    return  '';
                }
            })
            ->addColumn('name',function ($data){
                return $data->getTranslateName(app()->getLocale());
            })
            ->addColumn('action', 'dashboard.main.areas.partials._action');
    }

    public function query(Area $model)
    {
        $q = $model->newQuery();
        $q->with('city');
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
            Column::make('name')->title(__('site.area_name'))->data('name')->name('name'),
            Column::make('city_name')->title(__('site.city_name'))->data('city_name')->name('city_name'),
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
        return 'City_' . date('YmdHis');
    }
}
