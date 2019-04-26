<?php

namespace App\DataTables;

use App\Model\Subject;
use Yajra\DataTables\Services\DataTable;

class SubjectDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)// creates a table containing all data of the given model
        ->addColumn('class', function ($subject) { //adds a column Named "class" on the table created  above
            $class=Subject::find($subject->id)->classRoom()->get();//gets all sections of a class by the table of normalised many to many relationship
            $count=count($class); //to check if the class has any section assigned to it
            $classList='<ol>';// to create an ordered list of section inside the section column
            foreach($class as $get){ //if there are multiple sections this function will loop until the last section hence getting all
                $classList=$classList.'<li>'.$get->name.'</li>';//overriding the classList variable by adding the previous classList variable with the list element containing the name of the class

            }
            $classList=$classList.'</ol>';// closing the ordered list by overriding the variable by adding the previous variable with the closing ordered list
//                dd($sec);
            if($count==0){// if the subject isnt assigned with any class then this will execute to inform user no class has been assigned to this
                $classList='<b>No Class Assigned</b>';// overrides the classList variable with a bold message informing that no class has been assigned
                return $classList;//returns the variable which contains "no class assigned" message
            }
//                dd($wow);
            return $classList;//returns the variable which contains  "the list of the class"
        })
            ->addColumn('action', function ($subject) {// adds the column action in the created table
                //returns the edit and delete button to the action column
                return '<a href="'.route('subject.edit',$subject->id).'" class="btn btn-sm btn-primary" style="margin:3px"> 
                        <i class="glyphicon glyphicon-edit"></i>Edit</a>
                        &nbsp;&nbsp;
                        <a href="'.route('subject.destroy',$subject->id).'" class="btn btn-sm btn-danger" id="delete">
                        <i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })

            ->editColumn('id', '{{$id}}')
            ->rawColumns([ 'class','action'])// makes the mentioned column raw which will allow to use html codes in the column
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Subject $model)
    {
        return $model->newQuery()->select('id', 'name', 'created_at');
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
            'class',
            'created_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Subject_' . date('YmdHis');
    }
}
