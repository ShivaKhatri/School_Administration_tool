<?php

namespace App\DataTables;

use App\Model\Fee;
use App\User;
use Yajra\DataTables\Services\DataTable;

class FeeDataTable extends DataTable
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
                if($student->paid_status==0)
                return '<a href="'.route('fee.edit',$student->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('fee.destroy',$student->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
                else
                    return '<b>Bill Already Published</b>';


            })
            ->addColumn('class', function ($student) {
                $class=Fee::find($student->id)->classRoom()->first();
                if($class==null){
                    $class='<b>Not Assigned To A Class</b>';
                }else
                    $class='<b>'.$class->name.'</b>';
                return $class;
            })
            ->addColumn('student', function ($student) {
                $class=Fee::find($student->id)->student()->first();
                if($class==null){
                    $class='<b>Assigned to class</b>';
                }else
                    $class='ID: '.$class->id. ' <b> '.$class->firstName.' '.$class->middleName.' '.$class->LastName.'</b>';
                return $class;
            })
            ->rawColumns(['class','student', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Fee $model)
    {
//['class_id', 'student_id', 'paid_status', 'staff_id', 'amount','description','session_year','name'];

        return $model->newQuery()->select('id', 'name as Title','description','paid_status','class_id','amount', 'student_id', 'session_year as Session','created_at as BilledDate');
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
            'Title',
            'description',
            'amount',
            'class',
            'student',
            'BilledDate',
            'Session'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Fee_' . date('YmdHis');
    }
}
