<?php

namespace App\Http\Controllers\Backend;

use App\Model\ClassRoom;
use App\Model\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.subject.indexSubject');
    }

    public function tableData()
    {
        //getting  all data in the table also refereed as model
        $subject = Subject::all();

        //calling Yajra Datatable function and passing the model as parameter
        return DataTables::of($subject) // creates a table containing all data of the given model
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
            ->rawColumns(['class', 'action'])// makes the mentioned column raw which will allow to use html codes in the column
            ->make(true)
            ;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class=ClassRoom::all();

            return view('backend.subject.createSubject')->with('class',$class);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subject=new Subject();
        $subject->name=$request->name;
        $subject->description=$request->description;
        $subject->save();

        $class_subject=DB::table('classroom_subject');
        if($request->class) {//if class are selected to a subject then this will execute
            foreach($request->class as $get) {//loops until the last class
//            dd($id);
                $class_subject->insert(['class_id' => $get, 'sub_id' => $subject->id]);//inserts class id and section id into the normalised many to many relationship table
                return redirect('staff/subject');//return to the subjects index page

            }
        }
        else{//if no classes are selected fo the subject then this will execute
            return redirect('staff/subject');//return to the subjects index page
        }
        return redirect('staff/subject');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class=ClassRoom::all();
        $subject=Subject::find($id);
        return view('backend.subject.editSubject')->with('subject',$subject)->with('class',$class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subject=Subject::find($id);
        $subject->update([
            'name'=>$request->name,
//            'updated_at'=>Carbon::now('asia/kathmandu'),
            'description'=>$request->description

        ]);
        $class_subject=DB::table('classroom_subject');
        $class_subject->where('sub_id','=',$id)->delete();
        if($request->class) {
            foreach($request->class as $get) {
//            dd($id);
                $class_subject->insert(['class_id' => $get, 'sub_id' => $id]);
                return redirect('staff/subject');

            }
        }
        else{
            return redirect('staff/subject');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->checkId($id)) {
            return redirect()->route('subject.index');
        }
        $class_subject=DB::table('classroom_subject');
        $class_subject->where('sub_id','=',$id)->delete();
        Subject::destroy($id);

        return 'success';
    }

    public function checkId($id)
    {
        $query = Subject::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }
}
