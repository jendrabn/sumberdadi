<?php

namespace App\DataTables\Admin;

use App\Models\Product;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('price', function ($product) {
                return 'Rp. '. number_format($product->price, 0, ',','.');
            })
            ->addColumn('action', function ($product) {
                return '<a href="'. route('admin.products.show', $product->id). '" class="btn btn-md btn-outline-primary" title="Detail '. $product->name .'"><i class="fa fa-eye"></i></a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
        return $model->newQuery()->with(['store', 'store.community', 'category']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('products')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('print'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('name'),
            Column::computed('price'),
            Column::make('stock'),
            Column::make('category')->data('category.name')->orderable(false)->searchable(false),
            Column::make('store')->data('store.name')->searchable(false),
            Column::make('community')->data('store.community.name')->orderable(false)->searchable(false),
            Column::make('created_at')->hidden(),
            Column::make('updated_at')->hidden(),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin\Product_' . date('YmdHis');
    }
}
