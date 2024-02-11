<?php

namespace App\DataTables\Seller;

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
            ->addColumn('category', function ($product) {
                return $product->category->name;
            })
            ->addColumn('weight_info', function ($product) {
                return $product->weight .' '. $product->weight_unit;
            })
            ->addColumn('action', function ($product) {
                return '<a href="'. route('seller.products.show', $product->id). '" class="btn btn-md btn-outline-primary" title="Detail '. $product->name .'"><i class="fa fa-eye"></i></a>';
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
        return $model->where('store_id', auth()->user()->community->store->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('products-table')
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
            Column::make('name')->title('Nama'),
            Column::computed('price')->orderable(false)->searchable(false)->title('Harga'),
            Column::make('stock'),
            Column::computed('weight_info')->searchable(false)->orderable(false)->title('Berat'),
            Column::computed('category')->orderable(false)->searchable(false),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Seller\Product_' . date('YmdHis');
    }
}
