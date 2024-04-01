<?php

namespace App\DataTables\Admin;

use App\Models\Store;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StoreDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.store.action')
            ->addColumn('community', function ($store) {
                return '<a href="' . route('admin.communities.show', $store->community->id) . '" title="Detail ' . $store->community->name . '">' . $store->community->name . '</a>';
            })
            ->addColumn('products', function ($store) {
                return $store->products->count();
            })
            ->addColumn('balance', function ($store) {
                return "Rp. " . number_format($store->balance, 0, ',', '.') . ",-";
            })
            ->rawColumns(['action', 'community', 'store'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Store $model): QueryBuilder
    {
        return $model->newQuery()->with(['community', 'products', 'balances']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('store-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->addClass('text-center')->title('ID'),
            Column::make('name'),
            Column::computed('community'),
            Column::computed('balance'),
            Column::computed('products'),
            Column::make('address'),
            Column::make('created_at')->hidden(),
            Column::make('updated_at')->hidden(),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Store_' . date('YmdHis');
    }
}
