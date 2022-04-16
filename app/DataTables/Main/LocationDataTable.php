<?php

namespace App\DataTables\Main;

use App\Models\Location;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LocationDataTable extends DataTable
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
            })->addColumn('area_name',function ($data){
                if($data->area){
                    return $data->area->getTranslateName(app()->getLocale());
                }else{
                    return  '';
                }
            })
            ->addColumn('address',function ($data){
                return $data->getTranslateAddress(app()->getLocale());
            })
            ->addColumn('action', 'dashboard.main.locations.partials._action');

    }

    public function query(Location $model)
    {
        $q = $model->newQuery();
        $q->with(['city','area']);
        $q->orderByDesc('id');
        return $q;
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('location-table')
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
            Column::make('address')->title(__('site.address'))->data('address')->name('address'),
            Column::make('city_name')->title(__('site.city_name'))->data('city_name')->name('city_name'),
            Column::make('area_name')->title(__('site.area_name'))->data('area_name')->name('area_name'),
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
        return 'Location_' . date('YmdHis');
    }
}
