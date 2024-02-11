<?php

namespace App\DataTables\Admin;

use App\Models\Store;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StoreDataTable extends DataTable
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
            ->addColumn('action', function ($store) {
                return '<a href="'. route('admin.stores.show', $store->slug). '" class="btn btn-md btn-outline-primary" title="Detail '. $store->name .'"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('community', function ($store) {
                return '<a href="'. route('admin.communities.show', $store->community->id). '" title="Detail '. $store->community->name .'">'. $store->community->name .'</a>';
            })
            ->addColumn('products', function ($store) {
                return $store->products->count();
            })
            ->addColumn('balance', function ($store) {
                return "Rp. ".number_format($store->balance, 0, ',','.') . ",-";
            })
            ->rawColumns(['action', 'community', 'store']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Store $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Store $model)
    {
        return $model->newQuery()->with(['community', 'products', 'balances']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('stores')
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
            Column::computed('community'),
            Column::computed('balance'),
            Column::computed('products'),
            Column::make('address'),
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
        return 'Stores_' . date('YmdHis');
    }
}
