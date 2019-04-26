<?php

namespace App\DataTables;

use App\Model\Attendance;
use App\Model\ClassRoom;
use App\Model\Section;
use App\Staff;
use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class AttendanceDataTable extends DataTable
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
            ->addColumn('section', function ($attendance) {
                $sec=Section::find($attendance->section_id);
                    $wow='<b>'.$sec->name.'</b>';
                return $wow;
            })
            ->addColumn('class', function ($attendance) {
                $class=ClassRoom::find($attendance->class_id);
                $wow='<b>'.$class->name.'</b>';
//                dd($wow);
                return $wow;
            })
            ->addColumn('staff', function ($attendance) {
                $class=Staff::find($attendance->staff_id);
                $wow='<b>'.$class->firstName.' '.$class->middleName.' '.$class->LastName.'</b>';
//                dd($wow);
                return $wow;
            })
            ->addColumn('present', function ($attendance) {
                $count=DB::table('attendance_students')->select('student_id')->where('attendance_id','=',$attendance->id)->where('present','=',1)->count('student_id');
                if($count==0){
                    $wow='<b>No one was present</b>';
                    return $wow;
                }
                else
                $wow='<b>'.$count.' students were present</b>';
//                dd($wow);
                return $wow;
            })
            ->addColumn('absent', function ($attendance) {
                $count1=DB::table('attendance_students')->select('student_id')->where('attendance_id','=',$attendance->id)->where('present','=',1)->count('student_id');

                $count=DB::table('attendance_students')->select('student_id')->where('attendance_id','=',$attendance->id)->where('present','=',0)->count('student_id');
                if($count1!=0) {
                    if ($count == 0) {
                        $wow = '<b>No one was absent</b>';
                        return $wow;
                    }else
                        $wow='<b>'.$count.' students were absent</b>';
                }else
                    $wow = '<b>Everyone was absent</b>';

//                dd($wow);
                return $wow;
            })
            ->addColumn('action', function ($class) {
                return '<a href="'.route('attendance.edit',$class->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('attendance.destroy',$class->id).'" class="btn btn-sm btn-danger" id="delete"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })

            ->rawColumns(['section', 'class', 'staff','absent','present', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Attendance $model)
    {
        return $model->newQuery()->select('id','section_id','staff_id','class_id', 'date', 'session');
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
           'date','section', 'class', 'staff','absent','present',
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
        return 'Attendance_' . date('YmdHis');
    }
}
