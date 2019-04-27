<?php

namespace App\DataTables;

use App\Model\Exam;
use Yajra\DataTables\Services\DataTable;

class ExamDataTable extends DataTable
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
            ->addColumn('class', function ($exam) {
                $exam=Exam::find($exam->id)->classRoom()->distinct()->get();
                $count=count($exam);
                $wow='<ol>';
                foreach($exam as $get){
                    $wow=$wow.'<li>'.$get->name.'</li>';

                }
                $wow=$wow.'</ol>';
//                dd($sec);
                if($count==0){
                    $wow='<b>No Class Assigned</b>';
                    return $wow;
                }
//                dd($wow);
                return $wow;
            })
            ->addColumn('subject', function ($exam) {
                $subject=Exam::find($exam->id)->subject()->distinct()->get();
                $count=count($subject);
                $wow='<ol>';
                foreach($subject as $get){
                    $wow=$wow.'<li>'.$get->name.'</li>';

                }
                $wow=$wow.'</ol>';
//                dd($sec);
                if($count==0){
                    $wow='<b>No Subject Assigned</b>';
                    return $wow;
                }
//                dd($wow);
                return $wow;
            })
            ->addColumn('action', function ($exam) {
                return '<a href="'.route('exam.show',$exam->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-eye-open"></i> Show</a>&nbsp;&nbsp;<a href="'.route('exam.edit',$exam->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.route('exam.destroy',$exam->id).'" class="btn btn-sm btn-danger" id="delete"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->editColumn('status', function ($exam) {
                $subject=Exam::find($exam->id);

                if($subject->status==0){
                    $html='<span class="badge badge-warning">Not Published</span>';
                }else{
                    $html='<span class="badge badge-success">Published</span>';
                }
//
                return $html;
            })
            ->rawColumns([ 'class','status','subject', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Exam $model)
    {
        return $model->newQuery()->select('id', 'name', 'from', 'to','resultDay','status');
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
            'from',
            'to',
            'status',
            'class',
            'subject',
            'resultDay'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Exam_' . date('YmdHis');
    }
}
