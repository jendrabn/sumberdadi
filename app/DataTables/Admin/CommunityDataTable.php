<?php

namespace App\DataTables\Admin;

use App\Models\Community;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CommunityDataTable extends DataTable
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
            ->addColumn('total_members', function ($community) {
                return $community->members()->count();
            })
            ->addColumn('action', function ($community) {
                return '<a href="'. route('admin.communities.show', $community->id). '" class="btn btn-md btn-outline-primary" title="Detail '. $community->name .'"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('img_logo', function ($community) {
                return '<img class="img-responsive rounded-circle" style="height: 50px" src="'. $community->logo_url .'">';
            })
            ->addColumn('handler', function ($community) {
                return '<a href="'. route('admin.users.show', $community->user->id). '">'. $community->user->full_name. '</a>';
            })
            ->rawColumns(['img_logo', 'action', 'handler']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Community $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Community $model)
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
                    ->setTableId('community')
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
            Column::make('id')->hidden(),
            Column::computed('total_members')->width(15)->orderable(false)->searchable(false)->addClass('text-center'),
            Column::make('name'),
            Column::computed('handler')->searchable(false)->orderable(false),
            Column::make('img_logo'),
            Column::make('founded_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Communities_' . date('YmdHis');
    }
}
