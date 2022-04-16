<?php

namespace App\DataTables\Pro;
use App\Models\Product;
use App\Models\ProductUnit;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductUnitDataTable extends DataTable
{
    private $product_id;

    function __construct($product_id) {
        $this->product_id = $product_id;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
           ->addColumn('unit_name',function ($data){
                return $data->getTranslateName(app()->getLocale());
            })
            ->addColumn('action', 'dashboard.product.products.units.partials._action')
            ->rawColumns(['action', 'is_available_name','image_path']);
    }

    public function query(ProductUnit $model)
    {
        $q = $model->newQuery();
        $q->orderByDesc('id');
        $q->where('product_id',$this->product_id);
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
            Column::make('unit_name')->title(__('site.unit_name'))->data('unit_name')->name('unit_name'),
            Column::make('price')->title(__('site.price'))->data('price')->name('price'),
            Column::make('quantity')->title(__('site.quantity'))->data('quantity')->name('quantity'),
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
