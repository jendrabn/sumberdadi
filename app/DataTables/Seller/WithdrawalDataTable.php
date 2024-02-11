<?php

namespace App\DataTables\Seller;

use App\Models\Withdrawal;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WithdrawalDataTable extends DataTable
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
            ->addColumn('amount', function ($withdrawal) {
                return 'Rp. '. number_format($withdrawal->amount, 0, ',','.');
            })
            ->addColumn('action', function ($withdrawal) {
                return '<a href="'. route('seller.withdrawals.show', $withdrawal->id). '" class="btn btn-md btn-outline-primary" title="Detail Withdrwal"><i class="fa fa-eye"></i></a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Withdrawal $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Withdrawal $model)
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
                    ->setTableId('withdrawals-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
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
            Column::computed('amount'),
            Column::make('status'),
            Column::make('bank'),
            Column::make('account_number')->title('Nomor Rekening'),
            Column::make('created_at')->title('Diajukan Pada'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Seller\Withdrawal_' . date('YmdHis');
    }
}
