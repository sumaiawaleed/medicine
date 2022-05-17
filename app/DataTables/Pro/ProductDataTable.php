<?php

namespace App\DataTables\Pro;

use App\Models\Product;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('category_name', function ($data) {
                if ($data->category) {
                    return $data->category->getTranslateName(app()->getLocale());
                } else {
                    return '';
                }
            })->addColumn('product_name', function ($data) {
                return $data->getTranslateName(app()->getLocale());
            })->addColumn('is_available_name', function ($data) {
                return $data->getAvailableLabel();
            })
            ->addColumn('image_path', function ($data) {
                return '<img src="' . $data->image_path . '" width="100px">';
            })
            ->addColumn('action', 'dashboard.product.products.partials._action')
            ->rawColumns(['action', 'is_available_name', 'image_path']);
    }

    public function query(Product $model)
    {
        $q = $model->newQuery();
        $q->with('category');
        $q->orderByDesc('id');
        if ($this->request->get('category_id'))
            $q->where('category_id', $this->request->get('category_id'));
        if ($this->request->get('query')) {
            $q->where('name', 'LIKE', '%' . $this->request->get('query') . '%')
                ->orWhere('scientific_name', 'LIKE', '%' . $this->request->get('query') . '%')
                ->orWhere('notes', 'LIKE', '%' . $this->request->get('query') . '%');
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
            Column::make('product_name')->title(__('site.product_name'))->data('product_name')->name('product_name'),
            Column::make('scientific_name')->title(__('site.scientific_name'))->data('scientific_name')->name('scientific_name'),
            Column::make('category_name')->title(__('site.category_name'))->data('category_name')->name('category_name'),
            Column::make('image_path')->title(__('site.image_path'))->data('image_path')->name('image_path'),
            Column::make('expire_date')->title(__('site.expire_date'))->data('expire_date')->name('expire_date'),
            Column::make('is_available_name')->title(__('site.is_available_name'))->data('is_available_name')->name('is_available_name'),
            Column::make('notes')->title(__('site.notes'))->data('notes')->name('notes'),
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
        return 'Product_' . date('YmdHis');
    }
}
