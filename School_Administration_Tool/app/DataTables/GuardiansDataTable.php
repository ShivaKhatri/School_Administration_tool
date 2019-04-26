<?php

namespace App\DataTables;

use App\Guardian;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class GuardiansDataTable extends DataTable
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
                return '<a href="'.route('guardian.edit',$student->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('guardian.destroy',$student->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->addColumn('students', function ($student) {
                $class=Guardian::find($student->id)->student()->get();
                $html='<ol>';
                if($class==null){
                    $html='<b>Not Students Assigned</b>';
                }else
                    foreach($class as $get){
                        $html=$html.'<li style="list-style: square;">ID: '.$get->id.' Name:'.$get->firstName.' '.$get->firstName.'</li>';

                    }
                $html=$html.'</ol>';
                return $html;
            })
            ->filterColumn('name', function ($query, $keyword) {

                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(firstName, middleName,lastName) like ?", ["%{$keywords}%"]);

            })
            ->editColumn('id', 'ID: {{$id}}')
            ->rawColumns(['students', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Guardian $model)
    {
        return $model->newQuery()->select('id', DB::raw('CONCAT(firstName, " ", middleName," ",lastName ) AS name'),'address','email','phone_no','mobile_no');
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
                    ->parameters($this->getShowParameters());
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
            'students',
            'address','email','phone_no','mobile_no'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Guardians_' . date('YmdHis');
    }
}
