<?php

namespace App\DataTables;

use App\Student;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class StudentsDataTable extends DataTable
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
                return '<a href="'.route('student.edit',$student->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('student.destroy',$student->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->addColumn('class', function ($student) {
                $class=Student::find($student->id)->classRoom()->first();
                if($class==null){
                    $class='<b>Not Assigned To A Class</b>';
                }else
                $class='<b>'.$class->name.'</b>';
                return $class;
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->rawColumns(['class', 'action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Student $model)
    {
        return $model->newQuery()->select('id', DB::raw('CONCAT(firstName, " ", middleName," ",lastName ) AS name'),'address','email','phone_no');
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
                    ->addAction(['width' => '180px'])
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
            'name','address','email','phone_no','class'

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Students_' . date('YmdHis');
    }
}
