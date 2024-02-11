<?php

namespace App\DataTables\Seller;

use App\Models\CommunityEvent;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CommunityEventDataTable extends DataTable
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
            ->addColumn('attendees', function ($event) {
                return $event->attendees->count() . ' / ' . $event->community->members->count();
            })
            ->addColumn('action', function ($event) {
                return '<a href="'. route('seller.events.show', $event->id). '" class="btn btn-md btn-outline-primary" title="Detail '. $event->name .'"><i class="fa fa-eye"></i></a>';
            })
            ->rawColumns(['action', 'community']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CommunityEvent $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CommunityEvent $model)
    {
        return $model->where('community_id', auth()->user()->community->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('events-table')
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
            Column::make('created_at')->hidden(),
            Column::make('id')->hidden(),
            Column::make('name')->title('Nama Kegiatan'),
            Column::computed('attendees')->searchable(false)->orderable(false)->title('Kehadiran'),
            Column::make('location')->title('Lokasi'),
            Column::make('started_at')->title('Dimulai Pada'),
            Column::make('ended_at')->title('Diakhiri Pada'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Events_' . date('YmdHis');
    }
}
