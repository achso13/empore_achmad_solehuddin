<?php

namespace App\DataTables;

use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PengajuanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $table = (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('status', function ($pengajuan) {
                $theme = "warning";
                if ($pengajuan['status'] === "approved") {
                    $theme = "success";
                } else if ($pengajuan['status'] === "rejected") {
                    $theme = "danger";
                } else if ($pengajuan['status'] === "returned") {
                    $theme = "primary";
                }
                return '<label class="badge bg-' . $theme . '">' . $pengajuan['status'] . '</label>';
            });
        if (Auth::guard('user')->check()) {
            return $table->rawColumns(['status']);
        }

        $table = $table->addColumn('action', function ($pengajuan) {
            if ($pengajuan['status'] === 'pending') {
                return '
                <div class="d-flex">  
                <form class="mr-2" action="' . route("pengajuan.status", ['id' => $pengajuan['id'], 'status' => 'approved']) . '" method="POST" onsubmit="return confirm(`Approve pengajuan?`);">
                    ' . csrf_field() . '
                ' . method_field('PUT') . '
                    <button type="submit" class="btn btn-xs btn-success">
                        Approve
                    </button>
                </form>
                <form action="' . route("pengajuan.status", ['id' => $pengajuan['id'], 'status' => 'rejected']) . '" method="POST" onsubmit="return confirm(`Reject pengajuan?`);">
                ' . csrf_field() . '
                ' . method_field('PUT') . '
                    <button type="submit" class="btn btn-xs btn-danger">
                        Reject
                    </button>
                </form>
                </div>  
     
                ';
            }
            return '
            <div class="d-flex">   
                <button class="btn btn-xs btn-success mr-2" disabled>
                   Approve
                </button>   
                <button class="btn btn-xs btn-danger" disabled>
                    Reject
                </button>
            </div>';
        })->rawColumns(['action', 'status']);

        return $table;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Pengajuan $model): QueryBuilder
    {
        return $model->newQuery()
            ->join('users', 'users.id', '=', 'pengajuan.id_user')
            ->join('buku', 'buku.id', '=', 'pengajuan.id_buku')
            ->select(
                'pengajuan.*',
                'users.name as nama',
                'buku.judul_buku'
            );
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pengajuan-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'responsive' => true,
                'autoWidth' => false
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('id'),
            Column::make('id_user'),
            Column::make('nama', "users.name"),
            Column::make('id_buku'),
            Column::make('judul_buku', 'buku.judul_buku'),
            Column::make('tanggal_peminjaman'),
            Column::make('tanggal_pengembalian'),
            Column::make('status'),
        ];

        if (Auth::guard('admin')->check()) {
            array_push(
                $columns,
                Column::computed('action')
                    ->title('Action')
                    ->exportable(false)
                    ->printable(false)
                    ->orderable(false)
                    ->searchable(false)
            );
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Pengajuan_' . date('YmdHis');
    }
}
