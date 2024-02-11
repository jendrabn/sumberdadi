<?php

namespace App\DataTables\Seller;

use App\Models\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
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
            ->addColumn('user', function ($order) {
                return $order->user->full_name;
            })
            ->addColumn('barang', function ($order) {
                return $order->items->count();
            })
            ->addColumn('total', function ($order) {
                return 'Rp. '. number_format($order->total_amount, 0, ',','.');
            })
            ->addColumn('action', function ($order) {
                return '<a href="'. route('seller.orders.show', $order->id). '" class="btn btn-md btn-outline-primary" title="Detail Pesanan"><i class="fa fa-eye"></i></a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->with('items')->where('store_id', auth()->user()->community->store->id)->whereNotNull('confirmed_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('orders-table')
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
            Column::computed('user','Customer')->orderable(false)->searchable(false),
            Column::computed('barang', 'Barang')->orderable(false)->searchable(false),
            Column::computed('total')->orderable(false)->searchable(false),
            Column::make('status'),
            Column::make('confirmed_at')->title('Konfirmasi'),
            Column::make('created_at')->title('Tanggal Pesanan'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Seller\Order_' . date('YmdHis');
    }
}
