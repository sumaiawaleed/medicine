<?php

namespace App\DataTables\People;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ClientDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image_path', function ($data) {
                return '<img src="' . $data->image_path . '" width="100px">';
            })->addColumn('type_name', function ($data) {
                if ($data->client) {
                    return $data->client->type_name;
                } else {
                    return '';
                }
            })->addColumn('company_name', function ($data) {
                if ($data->client) {
                    return $data->client->company_name;
                } else {
                    return '';
                }
            })->addColumn('subscribe', function ($data) {
                $result = '';
                if ($data->client) {
                    if ($data->client->getSubscribe()) {
                        $status = $data->client->subscribe_status == 1 ? __('site.active') : __('site.not_active');
                        $result .= __('site.one_subscribes') . ' : ' . $data->client->getSubscribe()->getTranslateName(app()->getLocale()) . '<br>';
                        $result .= __('site.subscribe_date') . ' : ' . $data->client->subscribe_date . '<br>';
                        $result .= __('site.subscribe_status') . ' : ' . $status;
                    }
                } else {
                    return '';
                }
                return $result;
            })
            ->addColumn('action', 'dashboard.people.clients.partials._action')
            ->rawColumns(['action', 'image_path', 'subscribe']);
    }

    public function query(User $model)
    {
        $q = $model->newQuery();
//        $q->join('clients','clients.user_id','=','users.id');
        $name = $this->request->get('query');
        $status = $this->request->get('status') == 1 ? ($this->request->get('status') == 2 ? 0 : null) : null;
        $q->with('client');
//        $q->where('name', 'LIKE', '%' . $this->request->get('query') . '%')
//            ->orWhere('clients.company_name', 'LIKE', '%' . $this->request->get('query') . '%');
        $q->where('type', 3);
        $q->orderByDesc('users.id');
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
            Column::make('company_name')->title(__('site.company_name'))->data('company_name')->name('company_name'),
            Column::make('email')->title(__('site.email'))->data('email')->name('email'),
            Column::make('phone')->title(__('site.phone'))->data('phone')->name('phone'),
            Column::make('image_path')->title(__('site.image_path'))->data('image_path')->name('image_path'),
            Column::make('type_name')->title(__('site.type_name'))->data('type_name')->name('type_name'),
            Column::make('subscribe')->title(__('site.subscribe'))->data('subscribe')->name('subscribe'),
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
