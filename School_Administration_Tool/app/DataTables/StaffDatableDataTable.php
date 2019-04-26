<?php

namespace App\DataTables;

use App\Staff;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class StaffDatableDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', function ($student) {
                return '<a href="'.route('staff.edit',$student->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('staff.destroy',$student->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Staff $model)
    {
        return $model->newQuery()->select('id',  DB::raw('CONCAT(firstName, " ", middleName," ",lastName ) AS name'), 'email','mobile_no','role');
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
                    ->addAction(['width' => '80px'])
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
            'email','mobile_no','role'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'StaffDatable_' . date('YmdHis');
    }
}
