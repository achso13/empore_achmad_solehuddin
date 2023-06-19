<?php

namespace App\DataTables;

use App\Models\Buku;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BukuDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('action', function ($buku) {
                if (Auth::guard('user')->check()) {
                    return '<a href="' . route("pengajuan.create", $buku['id']) . '" class="btn btn-xs btn-primary">
                    <i class="fa fa-edit"> Pinjam</i>
                </a>';
                }
                return '
                    <a href="' . route("buku.edit", $buku['id']) . '" class="btn btn-xs btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-xs btn-danger btn-delete" data-id="' . $buku['id'] . '">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Buku $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('buku-table')
            ->columns($this->getColumns())
            ->minifiedAjax();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('judul_buku'),
            Column::make('tahun_terbit'),
            Column::make('penulis'),
            Column::make('stok'),
            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Buku_' . date('YmdHis');
    }
}
