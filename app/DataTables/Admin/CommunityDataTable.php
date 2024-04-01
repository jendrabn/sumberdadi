<?php

namespace App\DataTables\Admin;

use App\Models\Community;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CommunityDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('total_members', function ($community) {
                return $community->members()->count();
            })
            ->addColumn('img_logo', function ($community) {
                return '<a href="' . $community->logo_url . '" target="_blank">
                            <img class="img-responsive" style="height: 25px" src="' . $community->logo_url . '">
                        </a>';
            })
            ->addColumn('handler', function ($community) {
                return '<a href="' . route('admin.users.show', $community->user->id) . '">' . $community->user->full_name . '</a>';
            })
            ->addColumn('action', 'admin.community.action')
            ->rawColumns(['img_logo', 'handler', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Community $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('community-table')
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
            Column::make('id')->title('ID'),
            Column::computed('total_members')->width(15)->orderable(false)->searchable(false)->addClass('text-center'),
            Column::make('name'),
            Column::computed('handler')->searchable(false)->orderable(false),
            Column::make('img_logo'),
            Column::make('founded_at'),
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
        return 'Community_' . date('YmdHis');
    }
}
