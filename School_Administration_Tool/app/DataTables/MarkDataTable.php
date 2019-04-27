<?php

namespace App\DataTables;

use App\Model\ClassRoom;
use App\Model\Exam;
use App\Model\Mark;
use App\Model\Section;
use App\Staff;
use App\User;
use Yajra\DataTables\Services\DataTable;

class MarkDataTable extends DataTable
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
            ->addColumn('Section', function ($mark) {
                $wow='';
                if($mark->sec_id!=null){
                $sec=Mark::find($mark->id)->section()->first();
                $wow='<b>'.$sec->name.'</b>';}
                else{
                    $wow='<b>No Section</b>';
                }
                return $wow;
            })

            ->addColumn('Class', function ($mark) {
                $class=ClassRoom::find($mark->class_id);
                $wow='<b>'.$class->name.'</b>';
//                dd($wow);
                return $wow;
            })
            ->addColumn('Staff', function ($mark) {
                $class=Staff::find($mark->staff_id);
                $wow='<b>'.$class->firstName.' '.$class->middleName.' '.$class->LastName.'</b>';
//                dd($wow);
                return $wow;
            })
            ->addColumn('Exam', function ($mark) {
                $exam=Exam::find($mark->exam_id);
                $wow='<b>'.$exam->name.'</b>';
//                dd($wow);
                return $wow;
            })
            ->addColumn('action', function ($class) {
                return '<a href="'.route('mark.edit',$class->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('mark.destroy',$class->id).'" class="btn btn-sm btn-danger" id="delete"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })

            ->rawColumns([ 'Class', 'Section', 'Exam', 'Staff','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Mark $model)
    {
        return $model->newQuery()->select('id', 'class_id', 'sec_id', 'exam_id', 'date', 'staff_id', 'session');
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

            'Class', 'Section', 'Exam', 'date', 'Staff',
            'session'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Mark_' . date('YmdHis');
    }
}
