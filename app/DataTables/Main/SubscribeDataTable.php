<?php

namespace App\DataTables\Main;

use App\Models\Subscribe;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubscribeDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('name', function ($data) {
                return $data->getTranslateName(app()->getLocale());
            })->addColumn('description', function ($data) {
                return $data->getTranslateDesc(app()->getLocale());
            })
            ->addColumn('action', 'dashboard.main.subscribes.partials._action');
    }

    public function query(Subscribe $model)
    {
        $q = $model->newQuery();
        $q->orderByDesc('id');
        if ($this->request->get('query')) {
            $q->where('name', 'LIKE', '%' . $this->request->get('query') . '%')
                ->orWhere('description', 'LIKE', '%' . $this->request->get('query') . '%');
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
            Column::make('name')->title(__('site.name'))->data('name')->name('name'),
            Column::make('description')->title(__('site.description'))->data('description')->name('description'),
            Column::make('price')->title(__('site.price'))->data('price')->name('price'),
            Column::make('period')->title(__('site.period'))->data('period')->name('period'),
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
        return 'Subscribe_' . date('YmdHis');
    }
}
