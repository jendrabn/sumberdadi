<?php

namespace App\DataTables\Admin;

use App\Models\CommunityEvent;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CommunityEventDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('attendees', function ($event) {
                return $event->attendees->count() . ' / ' . $event->community->members->count();
            })
            ->addColumn('community', function ($event) {
                return '<a href="' . route('admin.communities.show', $event->community->id) . '" title="Detail ' . $event->community->name . '">' . $event->community->name . '</a>';
            })
            ->addColumn('action', 'admin.event.action')
            ->rawColumns(['action', 'community'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CommunityEvent $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('communityevent-table')
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
            Column::make('id')->class('text-center')->title('ID'),
            Column::make('created_at')->hidden(),
            Column::make('name'),
            Column::computed('community')->searchable(false)->orderable(false),
            Column::computed('attendees')->searchable(false)->orderable(false),
            Column::make('location'),
            Column::make('started_at'),
            Column::make('ended_at'),
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
        return 'CommunityEvent_' . date('YmdHis');
    }
}
