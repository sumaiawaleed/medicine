<?php

namespace App\DataTables\Pro;
use App\Models\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('name',function ($data){
                return $data->getTranslateName(app()->getLocale());
            })
            ->addColumn('parent_name',function ($data){
                if($data->parent()){
                    return $data->parent()->getTranslateName(app()->getLocale());
                }else{
                    return  __('site.not_exist');
                }
            })
            ->addColumn('action', 'dashboard.main.categories.partials._action');
    }

    public function query(Category $model)
    {
        $q = $model->newQuery();
        $q->orderByDesc('id');
        if($this->request->get('parent_id'))
            $q->where('parent_id',$this->request->get('parent_id'));
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
            Column::make('name')->title(__('site.category_name'))->data('name')->name('name'),
            Column::make('parent_name')->title(__('site.parent_name'))->data('parent_name')->name('parent_name'),
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
