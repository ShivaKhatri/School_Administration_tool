<?php

namespace App\DataTables;

use App\Model\Section;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class SectionsDataTable extends DataTable
{
//public $section;
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
//        $section = DB::table('sections')
//            ->select(['id', 'name', 'description', 'created_at', 'updated_at']);
        return datatables($query)
            ->addColumn('action', function ($section) {
                return '<a href="'.route('section.edit',$section->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('section.destroy',$section->id).'" class="btn btn-sm btn-danger" id="delete"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->rawColumns(['action'])
            ->editColumn('id', 'ID: {{$id}}');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Section $model)
    {
        return $model->newQuery()->select('id', 'name','description', 'created_at', 'updated_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '10px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'name',
            'description',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Sections_' . date('YmdHis');
    }
}
