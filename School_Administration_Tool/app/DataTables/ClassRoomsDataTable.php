<?php

namespace App\DataTables;

use App\Model\ClassRoom;
use Yajra\DataTables\Services\DataTable;

class ClassRoomsDataTable extends DataTable
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
            ->addColumn('section', function ($class) {
                $sec=ClassRoom::find($class->id)->section()->get();
                $count=count($sec);
                $wow='<ol>';
                foreach($sec as $get){
                    $wow=$wow.'<li>'.$get->name.'</li>';

                }
                $wow=$wow.'</ol>';
//                dd($sec);
                if($count==0){
                    $wow='<b>No Section Assigned</b>';
                    return $wow;
                }
//                dd($wow);
                return $wow;
            })
            ->addColumn('subject', function ($class) {
                $subject=ClassRoom::find($class->id)->subject()->get();
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
            ->addColumn('action', function ($class) {
                return '<a href="'.route('class.edit',$class->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('class.destroy',$class->id).'" class="btn btn-sm btn-danger" id="delete"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })

            ->editColumn('id', '{{$id}}')
            ->rawColumns(['section', 'subject', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ClassRoom $model)
    {
        return $model->newQuery()->select('id', 'name', 'description', 'created_at', 'updated_at');
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
            'description',
            'section',
            'subject',
            'created_at',
            'updated_at',

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ClassRooms_' . date('YmdHis');
    }
}
