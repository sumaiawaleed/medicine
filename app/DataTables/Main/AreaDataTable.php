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
            ->addColumn('city_name', function ($data) {
                if ($data->city) {
                    return $data->city->getTranslateName(app()->getLocale());
                } else {
                    return '';
                }
            })
            ->addColumn('ar_name', function ($data) {
                return $data->getTranslateName('ar');
            })->addColumn('en_name', function ($data) {
                return $data->getTranslateName('en');
            })
            ->addColumn('action', 'dashboard.main.areas.partials._action');
    }

    public function query(Area $model)
    {
        $q = $model->newQuery();
        $q->with('city');
        $q->orderByDesc('id');
        if($this->request->get('city_id'))
            $q->where('city_id',$this->request->get('city_id'));
        if($this->request->get('query')){
            $q->where('name', 'LIKE', '%'.$this->request->get('query').'%');
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
            Column::make('ar_name')->title(__('site.ar_name'))->data('ar_name')->name('ar_name'),
            Column::make('en_name')->title(__('site.en_name'))->data('en_name')->name('en_name'),
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
