<?php

namespace App\DataTables\Admin;

use App\Models\CommunityProposal;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProposalDataTable extends DataTable
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
            ->addColumn('action', function ($proposal) {
                return '<a href="'. route('admin.proposals.show', $proposal->id). '" class="btn btn-md btn-outline-primary" title="Detail Proposal"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('status', function ($proposal) {
                if (!empty($proposal->reject_reason) && !empty($proposal->rejected_at)) {
                    return 'DITOLAK';
                }
                return $proposal->approved_at ? 'DITERIMA' : '-';
            })
            ->addColumn('user', function ($proposal) {
                return $proposal->user->full_name;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CommunityProposal $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CommunityProposal $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('proposals-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
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
            Column::computed('user')->orderable(false)->searchable(false),
            Column::computed('status')->orderable(false)->searchable(false),
            Column::make('name'),
            Column::make('created_at')->title('Propose Date'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin\Proposal_' . date('YmdHis');
    }
}
