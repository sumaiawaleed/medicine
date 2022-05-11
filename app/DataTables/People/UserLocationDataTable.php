<?php

namespace App\DataTables\People;

use App\Models\UserLocation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserLocationDataTable extends DataTable
{
    private $user_id  = '';
    public function __construct($user_id = '')
    {
        $this->user_id = $user_id;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('is_current', function ($data) {
                return $data->is_current == 1 ? __('site.yes') : __('site.no');
            })->addColumn('city_name', function ($data) {
                return $data->city ? $data->city->getTranslateName(app()->getLocale()) : '';
            })->addColumn('area_name', function ($data) {
                return $data->area ? $data->area->getTranslateName(app()->getLocale()) : '';
            })->addColumn('location', function ($data) {
                return  $data->getTranslateName(app()->getLocale());
            })
            ->addColumn('action', 'dashboard.main.locations.partials._action');
    }
    public function query(UserLocation $model)
    {
        $q = $model->newQuery();
        $q->with(['area', 'city']);
        if ($this->user_id != 0) {
            $q->where('user_id', $this->user_id);
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
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reload')
                    );
    }

    protected function getColumns()
    {
        return [
            Column::make('id')->title('#')->data('id')->name('id'),
            Column::make('city_name')->title(__('site.city_name'))->data('city_name')->name('city_name'),
            Column::make('area_name')->title(__('site.area_name'))->data('area_name')->name('area_name'),
            Column::make('location')->title(__('site.location'))->data('location')->name('location'),
            Column::make('is_current')->title(__('site.is_current'))->data('is_current')->name('is_current'),
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
        return 'UserLocation_' . date('YmdHis');
    }
}
